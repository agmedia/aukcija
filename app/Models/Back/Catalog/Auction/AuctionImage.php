<?php

namespace App\Models\Back\Catalog\Auction;

use App\Helpers\AuctionHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;


class AuctionImage extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'auction_images';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Model
     */
    protected $resource;


    /**
     * @param $resource
     * @param $request
     *
     * @return mixed
     */
    public function store($resource, $request)
    {
        $this->resource = $resource;
        $existing       = isset($request['slim']) ? $request['slim'] : null;
        $new            = isset($request['files']) ? $request['files'] : null;

        //dd($request, $resource, $existing, $new);

        // Ako ima novih slika
        if ($new) {
            foreach ($new as $new_image) {
                if (isset($new_image['image']) && $new_image['image']) {
                    $data = json_decode($new_image['image']);

                    $saved = $this->saveNew($data->output, $new_image['sort_order']);
                    // Ako je novi default ujedno i novo uploadana fotka.
                    // Također ako je ime novo uploadane slike isto kao $existing['default']
                    if (
                        isset($new['default']) &&
                        strpos($new['default'], 'image/') !== false &&
                        $data->output->name == str_replace('image/', '', $new['default'])
                    ) {
                        $this->switchDefault($saved);
                    }
                }
            }
        }

        if ($existing) {
            // Ako se mijenja default i nismo ga već promjenili...
            if (isset($existing['default']) && $existing['default'] != 'on') {
                $this->switchDefault(
                    $this->where('id', $existing['default'])->first()
                );
            }

            foreach ($existing as $key => $image) {

                $title = $this->resource->name;

                if (isset($image['image']) && $image['image']) {
                    $data = json_decode($image['image']);

                    if ($data) {
                        $this->replace($key, $data->output, $title);
                    }
                }

                if ( ! $key) {
                    $this->saveMainTitle($title);
                }

                if ($key && $key != 'default') {
                    $published = (isset($image['published']) && $image['published'] == 'on') ? 1 : 0;

                    $this->where('id', $key)->update([
                        'alt'        => $image['alt'],
                        'sort_order' => $image['sort_order'],
                        'published'  => $published
                    ]);

                    $this->saveTitle($key, $title);
                }
            }
        }

        return $this->where('auction_id', $this->resource->id)->get();
    }


    /**
     * @param $id
     * @param $new
     *
     * @return mixed
     */
    public function replace($id, $new, $title)
    {
        // Nađi staru sliku i izdvoji path
        $old  = $id ? $this->where('id', $id)->first() : $this->resource;
        $path = str_replace('media/img/auctions/', '', $old['image']);
        // Obriši staru sliku
        Storage::disk('auctions')->delete($path);

        $path = $this->saveImage($new->image, $title);

        Log::info('replace');
        Log::info($path);

        // Ako nije glavna slika updejtaj path na auction_images DB
        if ($id) {
            return $this->where('id', $id)->update([
                'image' => config('filesystems.disks.auctions.url') . $path
            ]);
        }

        return Auction::where('id', $this->resource->id)->update([
            'image' => config('filesystems.disks.auctions.url') . $path
        ]);
    }


    /**
     * @param $new
     *
     * @return mixed
     */
    public function switchDefault($new)
    {
        //dd($new, $this->resource);
        if (isset($new->id)) {

            if ($this->resource->image) {
                $this->where('id', $new->id)->update([
                    'image' => $this->resource->image
                ]);
            } else {
                $this->where('id', $new->id)->delete();
            }

            Log::info('switchDefault');
            Log::info($new->image);

            Auction::where('id', $this->resource->id)->update([
                'image' => $new->image
            ]);
        }

        return $new;
    }


    /**
     * @param $new
     *
     * @return mixed
     */
    public function saveNew($new, $sort_order = 0)
    {
        $path = $this->saveImage($new->image);

        // Store image in auction_images DB
        $id = $this->insertGetId([
            'auction_id' => $this->resource->id,
            'image'      => config('filesystems.disks.auctions.url') . $path,
            'alt'        => $this->resource->name,
            'published'  => 1,
            'sort_order' => $sort_order,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return $this->find($id);
    }


    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @param string $title
     */
    private function saveMainTitle(string $title/*, string $alt*/)
    {
        $existing_clean = AuctionHelper::getCleanImageTitle($this->resource->image);

        if ($existing_clean != $title) {
            $path          = $this->resource->id . '/';
            $existing_full = AuctionHelper::getFullImageTitle($this->resource->image);
            $new_full      = AuctionHelper::setFullImageTitle($title);

            Log::info('saveMainTitle');
            Log::info($new_full);
            Log::info('existing full');
            Log::info($existing_full);

            Storage::disk('auctions')->move($path . $existing_full . '.jpg', $path . $new_full . '.jpg');
            Storage::disk('auctions')->move($path . $existing_full . '.webp', $path . $new_full . '.webp');
            Storage::disk('auctions')->move($path . $existing_full . '-thumb.webp', $path . $new_full . '-thumb.webp');

            Auction::where('id', $this->resource->id)->update([
                'image' => config('filesystems.disks.auctions.url') . $path . $new_full . '.jpg'
            ]);
        }

        /*Auction::where('id', $this->resource->id)->update([
            'image_alt' => $alt
        ]);*/
    }


    /**
     * @param int    $id
     * @param string $title
     */
    private function saveTitle(int $id, string $title)
    {
        $resource = $this->where('id', $id)->first();

        if ($resource && isset($resource->image)) {
            $existing_clean = AuctionHelper::getCleanImageTitle($resource->image);

            if ($existing_clean != $title) {
                $path          = $this->resource->id . '/';
                $existing_full = AuctionHelper::getFullImageTitle($resource->image);
                $new_full      = AuctionHelper::setFullImageTitle($title);

                Storage::disk('auctions')->move($path . $existing_full . '.jpg', $path . $new_full . '.jpg');
                Storage::disk('auctions')->move($path . $existing_full . '.webp', $path . $new_full . '.webp');
                Storage::disk('auctions')->move($path . $existing_full . '-thumb.webp', $path . $new_full . '-thumb.webp');

                $this->where('id', $id)->update([
                    'image' => config('filesystems.disks.auctions.url') . $path . $new_full . '.jpg'
                ]);
            }
        }
    }


    /**
     * @param $image
     *
     * @return string
     */
    private function saveImage($image, $title = null)
    {
        if ( ! $title) {
            $title = $this->resource->name;
        }

        $time = Str::random(4);
        $img  = Image::read($this->makeImageFromBase($image));
        $path = $this->resource->id . '/' . Str::slug($this->resource->name) . '-' . $time . '.';

        $path_jpg = $path . 'jpg';
        Storage::disk('auctions')->put($path_jpg, $img->toJpeg(90));

        $path_webp = $path . 'webp';
        Storage::disk('auctions')->put($path_webp, $img->toWebp(90));

        // Thumb creation
        $path_thumb = $this->resource->id . '/' . Str::slug($this->resource->name) . '-' . $time . '-thumb.';

        $img = $img->resize(288, 360)->resizeCanvas(288, 360);



        $path_webp_thumb = $path_thumb . 'webp';
        Storage::disk('auctions')->put($path_webp_thumb, $img->toWebp(80));

        return $path_jpg;
    }


    /**
     * @param string $base_64_string
     *
     * @return false|string
     */
    private function makeImageFromBase(string $base_64_string)
    {
        $image_parts = explode(";base64,", $base_64_string);

        return base64_decode($image_parts[1]);
    }


    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @param int $auction_id
     *
     * @return Collection
     */
    public static function getAdminList(int $auction_id = null): Collection
    {
        $response = [];

        if ($auction_id) {
            $images   = self::where('auction_id', $auction_id)->orderBy('sort_order')->get();

            foreach ($images as $image) {
                $response[] = [
                    'id'         => $image->id,
                    'auction_id' => $image->auction_id,
                    'image'      => $image->image,
                    'title'      => AuctionHelper::getCleanImageTitle($image->image),
                    'alt'        => $image->alt,
                    'published'  => $image->published,
                    'sort_order' => $image->sort_order,
                ];
            }
        }

        return collect($response);
    }


    /**
     * Save stack of images to the
     * auction_images database.
     *
     * @param array $paths
     * @param       $auction_id
     *
     * @return array|bool
     */
    public static function saveStack(array $paths, $auction_id)
    {
        $images = [];

        foreach ($paths as $key => $path) {
            $images[] = self::create([
                'auction_id' => $auction_id,
                'image'      => $path,
                'sort_order' => $key,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        if ( ! empty($images)) {
            return $images;
        }

        return false;
    }


    /**
     * Save temporary stored images
     * to newly saved auction folder.
     * The folder is based on auction ID.
     *
     * @param array $paths
     * @param       $auction_id
     *
     * @return array|bool
     */
    public static function transferTemporaryImages(array $paths, $auction_id)
    {
        $targets = [];

        foreach ($paths as $key => $path) {
            $target    = str_replace('temp', $auction_id, $path);
            $targets[] = $target;

            if ($key == 0) {
                self::setDefault($target, $auction_id);
            }

            $_path   = str_replace(config('filesystems.disks.auctions.url'), '', $path);
            $_target = str_replace(config('filesystems.disks.auctions.url'), '', $target);

            Storage::disk('auctions')->move($_path, $_target);
            Storage::disk('auctions')->delete($_path);
        }

        return self::saveStack($targets, $auction_id);
    }


    /**
     * Set default auction image.
     *
     * @param string $path
     * @param        $id
     *
     * @return mixed
     */
    public static function setDefault(string $path, $id)
    {
        return Auction::where('id', $id)->update([
            'image' => $path
        ]);
    }

}
