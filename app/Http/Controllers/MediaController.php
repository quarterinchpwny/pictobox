<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $media = Media::all();
            return $this->successResponse($media, 'Media fetched successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMediaRequest $request)
    {
        try {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Store the file in the storage (e.g., Google Drive or S3)
            $path = $file->store('', 'google'); // Change 'google' to 's3' if using S3

            $media = Media::create([
                'filename' => $filename,
                'path' => $path,
                'type' => $request->type,
                'event_id' => $request->event_id,
            ]);

            return $this->successResponse($media, 'Media uploaded successfully', 201);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        try {
            return $this->successResponse($media, 'Media fetched successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMediaRequest $request, Media $media)
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();

                // Delete the old file from storage
                Storage::disk('google')->delete($media->path);

                // Store the new file in the storage (e.g., Google Drive or S3)
                $path = $file->store('', 'google'); // Change 'google' to 's3' if using S3

                $media->update([
                    'filename' => $filename,
                    'path' => $path,
                    'type' => $request->type ?? $media->type,
                    'event_id' => $request->event_id ?? $media->event_id,
                ]);
            } else {
                $media->update($request->only('event_id', 'type'));
            }

            return $this->successResponse($media, 'Media updated successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        try {
            // Delete the file from storage
            Storage::disk('google')->delete($media->path); // Change 'google' to 's3' if using S3

            // Delete the media record from the database
            $media->delete();

            return $this->successResponse(null, 'Media deleted successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
