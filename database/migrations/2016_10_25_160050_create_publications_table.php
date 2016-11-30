<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->comment('Oauth2 client_id');
            $table->string('name')->nullable()->comment('配置方案名称');
            $table->string('source')->nullable()->comment('渠道来源');
            $table->string('os')->nullable()->comment('系统类型');
            $table->string('min_version')->nullable()->comment('最小版本号');
            $table->string('max_version')->nullable()->comment('最大版本号');
            $table->dateTime('min_time')->nullable()->comment('起始时间');
            $table->dateTime('max_time')->nullable()->comment('结束时间');
            $table->string('note')->nullable()->comment('备注');

            $table->string('publication_message')->nullable()->comment('公告消息');
            $table->json('uuids')->nullable()->comment('设备uuid列表,空则所有生效');
            $table->json('online_config')->nullable()->comment('在线配置');
            $table->json('server_list')->nullable()->comment('服务器列表');
            $table->json('hot_upgrade')->nullable()->comment('热更');

            $table->timestamps();
            $table->unsignedInteger('updated_by')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('publications');
    }

}
