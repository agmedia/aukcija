<?php

namespace  App\Models\Back\Catalog\Attributes;

use App\Models\Back\Settings\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Attributes extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'attributes';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    protected $request;


    /**
     * @param $value
     *
     * @return mixed
     */
    public function getGrupaAttribute($value)
    {
        return $this->translation->group_title;
    }


    /**
     * Validate new category Request.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'item' => 'required'
        ]);

        $this->request = $request;

        return $this;
    }


    /**
     * Store new category.
     *
     * @return false
     */
    public function create()
    {
        $group = $this->request->input('title')[config('app.locale')] ?? 'hr';

        foreach ($this->request->input('item') as $item) {
            $id = $this->insertGetId([
                'group'       => Str::slug($group),
                'type'        => $this->request->input('type'),
                'sort_order'  => $item['sort_order'] ?? 0,
                'status'      => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
                'updated_at'  => Carbon::now()
            ]);
        }

        return $this->find($id);
    }


    /**
     * @param Category $category
     *
     * @return false
     */
    public function edit()
    {
        $values = Attributes::query()->where('group', Str::slug($this->group))->get();
        $group = $this->request->input('title')[config('app.locale')] ?? 'hr';
        $items = collect($this->request->input('item'));

        foreach ($values as $value) {
            $item = $items->where('id', $value->id);

            if ( ! empty($item->first())) {
                $saved = $value->update([
                    'group'       => Str::slug($group),
                    'type'        => $this->request->input('type'),
                    'sort_order'  => $item->first()['sort_order'] ?? 0,
                    'status'      => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
                    'updated_at'  => Carbon::now()
                ]);
            }
        }

        foreach ($items->where('id', '==', '0') as $item) {
            $id = $this->insertGetId([
                'group'       => Str::slug($group),
                'type'        => $this->request->input('type'),
                'sort_order'  => $item['sort_order'] ?? 0,
                'status'      => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
                'updated_at'  => Carbon::now()
            ]);
        }

        if ($items->count() < $values->count()) {
            $diff = $values->diffUsing($items, function ($one, $other) {
                return $other['id'] - $one['id'];
            });

            if ($diff->count()) {
                foreach ($diff as $item) {
                    Attributes::query()->where('id', $item['id'])->delete();
                }
            }

        }

        return true;
    }
    
    
    /**
     * @return array
     */
    public function getList()
    {
        $response = [];
        $values = Attributes::query()->get();

        foreach ($values as $value) {
            $response[$value->group]['group'] = $value->translation->group_title;
            $response[$value->group]['items'][] = [
                'id' => $value->id,
                'title' => $value->translation->title,
                'sort_order' => $value->sort_order
            ];
        }

        return $response;
    }
}
