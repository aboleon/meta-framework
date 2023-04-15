<?php


namespace MetaFramework\Controllers;

use Illuminate\Support\Facades\DB;
use MetaFramework\Models\Meta;
use MetaFramework\Services\Validation\ValidationTrait;
use MetaFramework\Traits\Ajax;
use Throwable;

class AjaxController extends Controller
{
    use Ajax;
    use ValidationTrait;


    /**
     * Statut de publication d'un élément ayant la propriété "published" en DB
     * via la fonctionnalité JS agnostique dédiée
     */
    protected function publishedStatus(): array
    {
        $result = [];
        if (request()->filled('class') && request()->filled('id') && class_exists(request('class'))) {
            $class = request('class');
            $object = new $class;
            $object = $object->find(request('id'));
            $object->published = (request('from') == 'online' ? 0 : 1);
            $object->save();
            $result['success'] = 1;
        } else {
            $result['error'] = 1;
        }
        return $result;
    }

    /**
     * Fonction générique drag&drop sur des éléments ayant la classe '.sortable"
     */
    protected function sortable(): array
    {
        $targets = ['content'];

        if (in_array(request('target'), $targets) && request()->filled('data')) {
            DB::beginTransaction();
            foreach (request('data') as $item) {
                DB::table(request('target'))->where('id', $item['id'])->update(['position' => $item['index']]);
            }
            DB::commit();
            $this->responseSuccess("L'ordre a été mis à jour");
            return $this->fetchResponse();
        }
        return [];
    }


    public function addMetaBloc()
    {
        try {
            $meta = Meta::makeMeta('bloc');
            $meta->parent = request('parent');
            $meta->taxonomy = request('bloc');
            $meta->save();

            $this->responseSuccess("Le bloc " . request('bloc')::getLabel() . ' a été ajouté à ' . $meta->hasParent->title);
            $this->responseElement('meta', $meta);
            $this->responseElement('callback', 'redirectAfterMetaBloc');

        } catch (Throwable $e) {
            $this->responseException($e);
        }
        return $this->fetchResponse();

    }

}
