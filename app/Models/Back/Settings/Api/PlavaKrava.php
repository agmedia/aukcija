<?php

namespace App\Models\Back\Settings\Api;

use App\Helpers\ApiHelper;
use App\Helpers\Helper;
use App\Helpers\Import;
use App\Helpers\ProductHelper;
use App\Helpers\Query;
use App\Models\Back\Catalog\Product\Auction;
use App\Models\Back\Catalog\Product\AuctionCategory;
use App\Models\Back\Settings\Settings;
use App\Models\Back\TempTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PlavaKrava
{

    /**
     * @var array|null
     */
    protected $request;


    /**
     * @param Request $request
     *
     * @return false|string
     */
    public function upload(Request $request)
    {
        $saved = Storage::disk('assets')->putFileAs('xls/', $request->file('file'), 'plava-krava.xlsx');

        if ($saved) {
            return public_path('assets/xls/plava-krava.xlsx');
        }

        return false;
    }


    /**
     * @param array $request
     *
     * @return false|\Illuminate\Http\JsonResponse|int|string
     */
    public function process(array $request, array $data = null)
    {
        if ($request) {
            $this->request = $request;

            switch ($this->request['method']) {
                case 'upload-excel':
                    return $this->importNewProducts($data);
            }
        }

        return false;
    }


    /**
     * @return int
     */
    private function importNewProducts(array $data = null)
    {
        $count = 0;

       // Log::info('Error downloading image: ' . $data);

        foreach ($data as $key => $item) {


            if ($key > 1) {
                $exist = Auction::query()->where('sku', $item[4])->first();

                if ( ! $exist && ! empty($item[3])) {
                    $import       = new Import();
                    $publisher_id = 0;
                    $author_id    = 0;

                    if (isset($item[2])) {
                        $publisher_id = $import->resolvePublisher($item[2]);
                    }
                    if ($item[1]) {
                        $author_id = $import->resolveAuthor($item[1]);
                    }

                    $id = Auction::query()->insertGetId([
                        'author_id'            => $author_id,
                        'publisher_id'         => $publisher_id,
                        'action_id'            => 0,
                        'name'                 => $item[3],
                        'sku'                  => $item[4],
                        'polica'               => null,
                        'description'          => $item[7],
                        'slug'                 => Helper::resolveSlug($item, '3'),
                        'price'                => $item[11],
                        'quantity'             => $item[12] ?: 0,
                        'decrease'             => 1,
                        'tax_id'               => config('settings.default_tax_id'),
                        'special'              => null,
                        'special_from'         => null,
                        'special_to'           => null,
                        'meta_title'           => $item[15],
                        'meta_description'     => $item[16],
                        'pages'                => $item[17],
                        'dimensions'           => $item[18],
                        'origin'               => $item[19],
                        'letter'               => null,
                        'condition'            => null,
                        'binding'              => $item[20],
                        'year'                 => $item[21],
                        'viewed'               => 0,
                        'sort_order'           => 0,
                        'push'                 => 0,
                        'status'               => $item[23] ? 1 : 0,
                        'created_at'           => Carbon::now(),
                        'updated_at'           => Carbon::now()
                    ]);

                    if ($id) {
                      /*  $image = config('settings.image_default');
                        try {
                            $image_path = public_path('/media/img/products/plava-krava/' . $item[10]);
                            $image = $import->resolveImages($image_path, $item[3], $id);
                        } catch (\ErrorException $e) {
                            Log::info('Image not imported. Auction SKU: (' . $item[4] . ') - ' . $item[3]);
                            Log::info($e->getMessage());
                        }*/

                        $categories = $import->resolveStringCategories($item[9]);

                        AuctionCategory::storeData($categories, $id);

                        $product = Auction::query()->find($id);

                        $product->update([
                           /* 'image'           => $image,*/
                            'url'             => ProductHelper::url($product),
                            'category_string' => ProductHelper::categoryString($product)
                        ]);

                        $count++;
                    }
                }
            }
        }

        return ApiHelper::response(1, 'Importano je ' . $count . ' novih artikala u bazu.');
    }

}
