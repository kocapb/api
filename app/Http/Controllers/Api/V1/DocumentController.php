<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\EditRequest;
use App\Http\Requests\Document\ListRequest;
use App\Http\Resources\Document as DocumentResources;
use App\Http\Resources\DocumentCollection;
use App\Http\Resources\Error;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DocumentController
 * @package App\Http\Controllers\Api\V1
 */
class DocumentController extends Controller
{
    /**
     * @return DocumentResources|JsonResponse
     */
    public function create()
    {
        try {
            /** @var Document $document */
            $document = new Document();
            $document->save();
        } catch (\Exception $exception) {
            return (new Error($exception))->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new DocumentResources($document);
    }

    /**
     * @param $uuid
     * @return DocumentResources|JsonResponse
     */
    public function get($uuid)
    {
        return new DocumentResources(Document::findOrFail($uuid));
    }

    /**
     * @param $uuid
     * @param EditRequest $request
     * @return JsonResponse|object
     */
    public function edit($uuid, EditRequest $request)
    {
        try {
            /** @var Document $document */
            $document = Document::findOrFail($uuid);
            if (Document::STATUS_PUBLISHED === $document->status) {
                return (new DocumentResources($document))->response()->setStatusCode(Response::HTTP_BAD_REQUEST);
            }
            $document->payload = $request->json()->get('document')['payload'];
            $document->save();

        } catch (\Exception $exception) {
            return (new Error($exception))->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new DocumentResources($document);
    }

    /**
     * @param $uuid
     * @return DocumentResources|JsonResponse
     */
    public function publish($uuid)
    {
        /** @var Document $document */
        $document = Document::findOrFail($uuid);
        try {
            $document->status = Document::STATUS_PUBLISHED;
            $document->save();
        } catch (\Exception $exception) {
            return (new Error($exception))->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new DocumentResources($document);
    }

    /**
     * @param ListRequest $request
     * @return DocumentCollection|JsonResponse
     */
    public function getList(ListRequest $request)
    {
        return new DocumentCollection(
            Document::paginate($request->has('perPage') ? $request->get('perPage') : Document::PER_PAGE)
        );
    }
}
