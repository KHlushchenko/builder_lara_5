<?php namespace Vis\TranslationsCMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Trans extends Model
{
    protected $table = 'translations_phrases_cms';

    public static $rules = array(
        'phrase' => 'required|unique:translations_phrases_cms'
    );

    protected $fillable = array('phrase');

    public $timestamps = false;

    public function getTrans()
    {
        $res = $this->hasMany('Vis\TranslationsCMS\Translate', 'id_translations_phrase')->get()->toArray();

        if ($res) {
            foreach ($res as $k => $el) {
                $trans[$el['lang']] = $el['translate'];
            }

            return $trans;
        }
    }

    //заполниения масива кеша с переводами
    public static function fillCacheTrans()
    {
        if (Cache::tags('translations')->has('translations_cms')) {
            $arrayTranslate = Cache::tags('translations')->get('translations_cms');
        } else {
            $translationsGet = DB::table("translations_phrases_cms")->leftJoin(
                'translations_cms',
                'translations_cms.id_translations_phrase',
                '=',
                'translations_phrases_cms.id'
            )
                ->get(array("translate", "lang", "phrase"));

            $arrayTranslate = array();
            foreach ($translationsGet as $el) {
                $el = (array) $el;
                $arrayTranslate[$el['phrase']][$el['lang']] = $el['translate'];
            }
            Cache::tags('translations')->forever('translations_cms', $arrayTranslate);
        }

        return $arrayTranslate;
    }

    //перезапись кеша переводов
    public static function reCacheTrans()
    {
        Cache::tags('translations')->flush();
        self::fillCacheTrans();
    }
}
