<?php

namespace App\Models\Back\Catalog\Groups;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Groups extends Model
{

    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'groups';

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
    public function getGrupaGroups($value)
    {
        return $this->group_title;
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
            'title' => 'required'
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
        $id = $this->insertGetId($this->getModelArray(true));

        if ($id) {
            return $this->find($id);
        }

        return false;
    }


    /**
     * @param Category $category
     *
     * @return false
     */
    public function edit()
    {
        $saved = $this->update($this->getModelArray());

        if ($saved) {
            return $this;
        }

        return false;
    }


    /**
     * @return array
     */
    public function getList()
    {
        $response = [];
        $values   = Groups::query()->get();

        foreach ($values as $value) {
            $response[$value->group]['group']   = $value->translation->group_title;
            $response[$value->group]['items'][] = [
                'id'         => $value->id,
                'title'      => $value->translation->title,
                'sort_order' => $value->sort_order
            ];
        }

        return $response;
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    /**
     * @param bool $insert
     *
     * @return array
     */
    private function getModelArray(bool $insert = true): array
    {
        $response = [
            'group'      => Str::slug($this->request->input('title')),
            'title'      => $this->request->input('title'),
            'type'       => $this->request->input('type'),
            'sort_order' => $this->request->input('sort_order') ?: 0,
            'status'     => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'updated_at' => Carbon::now()
        ];

        if ($insert) {
            $response['created_at'] = Carbon::now();
        }

        return $response;
    }
}
