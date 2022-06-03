<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    const TYPE_ACTIVE = 'active';
    const TYPE_TRAINEE = 'trainee';
    const TYPE_FREELANCE = 'freelance';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'value_per_class',
        'value_per_vip_class',
        'color',
        'type',
        'zip_code',
        'address',
        'number',
        'neighborhood',
        'city',
        'state',
        'rg',
        'cpf',
        'admission_date',
        'resignation_date',
        'bank_agency',
        'bank_account',
        'bank_type',
        'bank_pix',
    ];

    /**
     * Function to get the types of teachers
     *
     * @return void
     */
    static public function getTypes()
    {
        return [
            self::TYPE_ACTIVE => "Ativo",
            self::TYPE_TRAINEE => "Em treinamento",
            self::TYPE_FREELANCE => "Freelance",
        ];
    }


    public function groupClasses()
    {
        return $this->hasMany(GroupClass::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function paragraphs()
    {
        return $this->hasMany(Paragraph::class);
    }

    public function files()
    {
        return $this->hasMany(TeacherFile::class);
    }

    /**
     * Convert Date Attribute PT-BR to EN
     *
     * @param  mixed $value
     * @return void
     */
    public function setAdmissionDateAttribute($value)
    {
        if( $value == null)
        {
            $this->attributes['admission_date'] = null;
        }
        if ('' != $value){
            $this->attributes['admission_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }

    }

    /**
     * * Convert Date Attribute EN to PT-BR
     *
     * @return void
     */
    public function getAdmissionDateAttribute()
    {
        if ('' != $this->attributes['admission_date']) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['admission_date'])->format('d/m/Y');
        }

        return '';
    }

    /**
     * Convert Date Attribute PT-BR to EN
     *
     * @param  mixed $value
     * @return void
     */
    public function setResignationDateAttribute($value)
    {
        if ('' != $value){
            $this->attributes['resignation_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            return;
        }

        $this->attributes['resignation_date'] = $value;
    }

    /**
     * * Convert Date Attribute EN to PT-BR
     *
     * @return void
     */
    public function getResignationDateAttribute()
    {
        if ('' != $this->attributes['resignation_date']) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['resignation_date'])->format('d/m/Y');
        }

        return '';
    }

}
