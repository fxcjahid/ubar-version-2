<?php

/**
 * Summary of namespace App\Models
 * @author Fxc Jahid <fxcjahid3@gmail.com>
 */

namespace App\Models;

use App\Enums\UserType;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class File extends Model
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'key',
        'disk',
        'path',
        'filename',
        'extension',
        'mime',
        'size',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //TODO:
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //TODO:
    ];

    /**
     * Get the file's path.
     *
     * @param string $path
     * @return string|null
     */
    public function getPathAttribute($path)
    {
        if (! is_null($path)) {
            return Storage::disk($this->disk)->url($path);
        }
    }

    /**
     * Summary of store
     * @param string $key
     * @param mixed $user_id
     * @param mixed $location
     * @param mixed $file
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public static function store($key = Null, $user_id, $location = 'media', $file)
    {
        // Place File to PUBLIC location

        $path = Storage::putFile($location, $file);

        // Insert File details to Database
        $file = File::create([
            'user_id'   => $user_id,
            'key'       => $key,
            'disk'      => config('filesystems.default'),
            'filename'  => $file->getClientOriginalName(),
            'path'      => $path,
            'extension' => $file->extension() ?? '',
            'mime'      => $file->getClientMimeType(),
            'size'      => $file->getSize(),
        ]);

        return response()->json([
            $file,
        ]);
    }

    /**
     * Get post Creator
     * Relation between table
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}