<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku', 14)->default(0)->index();
            $table->string('ean', 14)->nullable();
            $table->string('group')->index();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('image')->nullable();
            $table->string('slug');
            $table->string('url', 255);
            $table->decimal('starting_price', 15, 4)->default(0);
            $table->decimal('current_price', 15, 4)->default(0);
            $table->decimal('reserve_price', 15, 4)->default(0);
            $table->decimal('min_increment')->default(0);
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('status')->default(1);
            $table->boolean('active')->default(false);
            $table->integer('tax_id')->unsigned()->default(0);
            $table->integer('viewed')->unsigned()->default(0);
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->unsigned()->default(0);
            $table->timestamps();
        });
        
        Schema::create('auction_bid', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auction_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->decimal('amount', 15, 4)->default(0);
            $table->timestamps();

            $table->foreign('auction_id')
                  ->references('id')
                  ->on('auctions')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });

        Schema::create('auction_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auction_id')->index();
            $table->string('image');
            $table->string('alt')->nullable();
            $table->boolean('default')->default(false);
            $table->boolean('published')->default(false);
            $table->integer('sort_order')->unsigned();
            $table->timestamps();

            $table->foreign('auction_id')
                ->references('id')
                ->on('auctions')
                ->onDelete('cascade');
        });
        
        Schema::create('auction_category', function (Blueprint $table) {
            $table->unsignedBigInteger('auction_id')->index();
            $table->unsignedBigInteger('category_id')->index();
            
            $table->foreign('auction_id')
                ->references('id')
                ->on('auctions')
                ->onDelete('cascade');
            
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
        
        Schema::create('auction_related', function (Blueprint $table) {
            $table->unsignedBigInteger('auction_id')->index();
            $table->unsignedBigInteger('related_auction_id')->index();
            
            $table->foreign('auction_id')
                ->references('id')
                ->on('auctions')
                ->onDelete('cascade');
            
            $table->foreign('related_auction_id')
                ->references('id')
                ->on('auctions');
        });

        Schema::create('auction_attribute', function (Blueprint $table) {
            $table->unsignedBigInteger('auction_id')->index();
            $table->unsignedBigInteger('attribute_id')->index();
            $table->string('value');
            $table->text('data')->nullable();

            $table->foreign('auction_id')
                ->references('id')
                ->on('auctions')
                ->onDelete('cascade');

            $table->foreign('attribute_id')
                ->references('id')
                ->on('attributes')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auctions');
        Schema::dropIfExists('auction_bid');
        Schema::dropIfExists('auction_images');
        Schema::dropIfExists('auction_category');
        Schema::dropIfExists('auction_related');
        Schema::dropIfExists('auction_attribute');
    }
}



