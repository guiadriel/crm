<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property $student
 *
 * @method origin()
 * @method status()
 * @method groupclass()
 * @method logs()
 */
class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nickname',
        'email',
        'phone',
        'phone_message',
        'gender',
        'avatar',
        'status_id',
        'origin_id',
        'observations',
        'rg',
        'cpf',
        'zip_code',
        'address',
        'number',
        'neighborhood',
        'city',
        'state',
        'birthday_date',
        'responsible_id',
        'instagram',
        'facebook',
        'who_booked'
    ];

    public function origin()
    {
        return $this->belongsTo('App\Models\Origin', 'origin_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id');
    }

    public function groupclass()
    {
        return $this->belongsToMany('App\Models\GroupClass', 'group_classes_students', 'student_id', 'group_classes_id');
    }

    public function logs()
    {
        return $this->hasMany(StudentLog::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function lastContractActive()
    {
        $statuses = Status::select('id')->whereIn('description', [Status::STATUS_CANCELADO, Status::STATUS_EXECUTADO])->get()->toArray();
        $status_ids = array_map(function($status){
            return  $status['id'];
        }, $statuses );

        return $this->contracts()->whereNotIn('status_id', $status_ids)->orderBy('start_date', 'desc')->first();
    }

    public function lastContract()
    {
        return $this->contracts()->orderBy('start_date', 'desc')->first();
    }

    public function hasActiveContract()
    {
        $statuses = Status::select('id')->whereIn('description', [Status::STATUS_CANCELADO, Status::STATUS_EXECUTADO])->get()->toArray();
        $status_ids = array_map(function($status){
            return  $status['id'];
        }, $statuses );
        // $status = Status::where('description', '=', Status::STATUS_ATIVO)->first();
        if ($this->contracts()->whereNotIn('status_id', $status_ids)->first()) {
            return true;
        }

        return false;
    }

    public function files()
    {
        return $this->hasMany(StudentFile::class);
    }

    public function responsible()
    {
        return $this->belongsTo(Responsible::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function hasAnySchedule()
    {
        if($this->schedules()->first()){
            return true;
        }

        return false;
    }

    public function lastSchedule()
    {
        return $this->schedules()->orderByDesc('initial_date')->first() ?? null;
    }

    public function setBirthdayDateAttribute($value)
    {
        if ('' != $value )
            $this->attributes['birthday_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getBirthdayDateAttribute()
    {
        if ('' != $this->attributes['birthday_date']) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['birthday_date'])->format('d/m/Y');
        }

        return '';
    }
}
