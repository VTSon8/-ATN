<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('sku')->unique();
            $table->string('slug')->comment('seo');
            $table->unsignedBigInteger('category_id');
            $table->string('author')->nullable();
            $table->string('lang')->nullable();
            $table->string('translator')->nullable()->comment('người dịch');
            $table->string('imprint')->nullable()->comment('tên nhà xuất bản');
            $table->year('publishing_year')->comment('năm xuất bản');
            $table->integer('weight')->nullable()->comment('khối lượng');
            $table->string('size', 50)->nullable()->comment('kích thước');
            $table->tinyInteger('number_of_pages')->nullable()->comment('số trang');
            $table->string('form', 50)->nullable()->comment('hình thức');
            $table->string('thumb', 200)->comment('Hình đại diện của sản phẩm');
            $table->text('source_url')->nullable();
            $table->string('description');
            $table->text('detail');
            $table->unsignedBigInteger('supplier_id');
            $table->integer('number')->default(0);
            $table->integer('number_buy')->default(0);
            $table->tinyInteger('sale')->nullable();
            $table->integer('original_price');
            $table->integer('selling_price')->nullable();
            $table->double('avg_rate')->nullable()->default('0');
            $table->boolean('status')->default(true);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')
                ->onUpdate('CASCADE');
            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->onDelete('cascade');
            $table->index(['name', 'slug'], 'fulltext_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
