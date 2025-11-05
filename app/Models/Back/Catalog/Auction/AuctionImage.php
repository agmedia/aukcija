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

                    $saved = $this->saveNew($data->output, $new_image['sort_order'] ?: 0);
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
                if (isset($image['image']) && $image['image']) {
                    $data = json_decode($image['image']);

                    if ($data) {
                        $this->replace($key, $data->output, $image['title']);
                    }
                }

                if ( ! $key) {
                    $this->saveMainTitle($image['title']);
                    //$this->saveMainTitle($image['title'], $image['alt']);
                    // zamjeni title na glavnoj
                }

                if ($key && $key != 'default') {
                    $published = (isset($image['published']) && $image['published'] == 'on') ? 1 : 0;

                    $this->where('id', $key)->update([
                        'alt'        => $image['alt'],
                        'sort_order' => $image['sort_order'],
                        'published'  => $published
                    ]);

                    $this->saveTitle($key, $image['title']);
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
            Log::info('existingfull');
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
        $t0   = microtime(true);
        $mem0 = memory_get_usage(true);

        try {
            if (!$title) {
                $title = $this->resource->name;
            }

            // Osnovni kontekst o okruženju / driveru
            Log::info('saveImage:start', [
                'auction_id' => $this->resource->id ?? null,
                'title'      => $title,
                'driver'     => config('image.driver') ?? 'unknown',
                'imagick'    => extension_loaded('imagick'),
                'gd'         => extension_loaded('gd'),
            ]);

            // 1) Base64 -> bin
            $b64len = strlen($image);
            Log::info('saveImage:incoming_base64', ['length_bytes' => $b64len]);

            $binary = $this->makeImageFromBase($image);
            $binLen = strlen($binary);
            Log::info('saveImage:decoded_binary', ['length_bytes' => $binLen]);

            // 2) Meta iz originalnog bina (mime + dimenzije)
            $meta = @getimagesizefromstring($binary);
            $mime = $meta['mime'] ?? null;
            $w0   = $meta[0] ?? null;
            $h0   = $meta[1] ?? null;
            Log::info('saveImage:source_meta', ['mime' => $mime, 'width' => $w0, 'height' => $h0]);

            // 3) Učitavanje slike + orijentacija
            $img = Image::read($binary)->orient();
            if (method_exists($img, 'width') && method_exists($img, 'height')) {
                Log::info('saveImage:loaded', ['width' => $img->width(), 'height' => $img->height()]);
            }

            // 4) Downscale prije enkodiranja (smanjuje memoriju i IO)
            $max = 2000; // po potrebi promijeni
            $img = $img->resize($max, $max, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });

            if (method_exists($img, 'width') && method_exists($img, 'height')) {
                Log::info('saveImage:resized', ['width' => $img->width(), 'height' => $img->height(), 'max' => $max]);
            }

            // 5) Putanje
            $time = Str::random(4);
            $slug = Str::slug($this->resource->name) . '-' . $time;
            $dir  = $this->resource->id . '/';

            $path_jpg       = $dir . $slug . '.jpg';
            $path_webp      = $dir . $slug . '.webp';
            $path_webp_thumb= $dir . $slug . '-thumb.webp';

            // 6) Enkodiranje u buffer (da izmjerimo veličine)
            $jpgBin  = (string) $img->toJpeg(80);
            $webpBin = (string) $img->toWebp(80);

            Log::info('saveImage:encoded_main', [
                'jpg_bytes'  => strlen($jpgBin),
                'webp_bytes' => strlen($webpBin),
            ]);

            // 7) Spremanje glavnih fajlova
            Storage::disk('auctions')->put($path_jpg, $jpgBin, [
                'visibility'            => 'public',
                'directory_visibility'  => 'public',
            ]);

            Storage::disk('auctions')->put($path_webp, $webpBin, [
                'visibility'            => 'public',
                'directory_visibility'  => 'public',
            ]);

            // 8) Thumb (288x360 canvas)
            $thumb = $img->resize(288, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })->resizeCanvas(288, 360);

            $thumbBin = (string) $thumb->toWebp(75);
            Log::info('saveImage:encoded_thumb', ['thumb_bytes' => strlen($thumbBin)]);

            Storage::disk('auctions')->put($path_webp_thumb, $thumbBin, [
                'visibility'            => 'public',
                'directory_visibility'  => 'public',
            ]);

            // 9) Veličine na disku
            $jpgSize   = Storage::disk('auctions')->size($path_jpg);
            $webpSize  = Storage::disk('auctions')->size($path_webp);
            $twebpSize = Storage::disk('auctions')->size($path_webp_thumb);

            Log::info('saveImage:saved_files', [
                'jpg_path'    => $path_jpg,
                'jpg_size'    => $jpgSize,
                'webp_path'   => $path_webp,
                'webp_size'   => $webpSize,
                'thumb_path'  => $path_webp_thumb,
                'thumb_size'  => $twebpSize,
                'public_url'  => config('filesystems.disks.auctions.url') . $path_jpg,
            ]);

            // 10) Performanse / memorija
            $t1   = microtime(true);
            $mem1 = memory_get_usage(true);
            $peak = memory_get_peak_usage(true);

            Log::info('saveImage:perf', [
                'time_ms'  => round(($t1 - $t0) * 1000, 1),
                'mem_used' => $mem1 - $mem0,
                'mem_peak' => $peak,
            ]);

            // Važno: vraća istu vrijednost kao tvoja originalna funkcija
            return $path_jpg;
        } catch (\Throwable $e) {
            Log::error('saveImage:exception', [
                'auction_id' => $this->resource->id ?? null,
                'message'    => $e->getMessage(),
                'code'       => $e->getCode(),
                'trace'      => substr($e->getTraceAsString(), 0, 4000),
            ]);
            throw $e;
        }
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
