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
            $table->string('package_name')->comment('软件包名');
            $table->string('min_version')->nullable()->comment('最小版本号');
            $table->string('max_version')->nullable()->comment('最大版本号');
            $table->dateTime('min_time')->nullable()->comment('起始时间');
            $table->dateTime('max_time')->nullable()->comment('结束时间');
            $table->text('uuids')->nullable()->comment('设备uuid列表,空则所有生效');

            $table->text('publication_message')->nullable()->comment('公告消息');
            $table->text('online_config')->nullable()->comment('在线配置');
            $table->text('server_list')->nullable()->comment('服务器列表');
            $table->text('hot_upgrade')->nullable()->comment('热更');

            $table->unsignedInteger('created_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->ipAddress('created_ip')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->ipAddress('updated_ip')->nullable();
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
