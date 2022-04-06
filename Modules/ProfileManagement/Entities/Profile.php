<?php

namespace Modules\ProfileManagement\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ProfileManagement\Database\Factories\ProfileFactory;

class Profile extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'profile_pic_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function RegisterMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100)
            ->nonQueued();

        $this->addMediaConversion('big picture')
            ->width(200)
            ->height(200);
    }

    protected static function newFactory()
    {
        return ProfileFactory::new();
    }
}
