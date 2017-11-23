<?php

use yii\db\Migration;

/**
 * Class m171122_095627_table_short_link
 */
class m171122_095627_table_short_link extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE short_url (
              id INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
              url VARCHAR(2048) NOT NULL COMMENT 'Длинная ссылка',
              cod VARCHAR(20) NOT NULL COMMENT 'Код',
              md5 varchar(40) NOT NULL COMMENT 'MD5 от url',
              PRIMARY KEY (id),
              UNIQUE INDEX UK_short_url_cod (cod),
              UNIQUE INDEX UK_short_url_md5 (md5),
              INDEX IDX_short_url_url (url)
            )
            ENGINE = INNODB
            COMMENT = 'Список ссылок';   
        ");
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('short_url');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171122_095627_table_short_link cannot be reverted.\n";

        return false;
    }
    */
}
