<?php

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSubCategoryIdOnEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_category_id')->after('category_id')->nullable();
        });


        $contract = Category::where('name', '=', 'CONTRATOS')->first();

        if( !$contract){
            $category = Category::create([
                'name' => 'CONTRATOS'
            ]);

            SubCategory::create([
                'category_id' => $category->id,
                'name' => 'CONTRATOS'
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->dropColumn('sub_category_id');
        });

        DB::table('categories')->whereIn('name', ['CONTRATOS'])->delete();
        DB::table('sub_categories')->whereIn('name', ['CONTRATOS'])->delete();
    }
}
