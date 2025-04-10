<?php

use yii\db\Migration;

class m250407_205105_trigger extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        CREATE TRIGGER check_nomination_limit
        AFTER INSERT ON users
        FOR EACH ROW
        BEGIN
            DECLARE participant_count INT;
            DECLARE max_allowed INT;
            
            SELECT COUNT(*) INTO participant_count 
            FROM users
            WHERE nomination_id = NEW.nomination_id;
            
            SELECT max_users INTO max_allowed 
            FROM nominations
            WHERE id = NEW.nomination_id;
            
            IF participant_count >= max_allowed THEN
                UPDATE nominations 
                SET active = FALSE 
                WHERE id = NEW.nomination_id;
            END IF;
        END;
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("DROP TRIGGER IF EXISTS check_nomination_limit");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250407_205105_trigger cannot be reverted.\n";

        return false;
    }
    */
}
