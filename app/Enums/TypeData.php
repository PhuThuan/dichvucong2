<?php


namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TypeData extends Enum
{
    const roleUser =['user'=>0,'admin'=>1];
    const htmlType = [
        'text' => 0, 'number' =>1 , 'checkbox' => 2, 'email' => 3,'password'=>4, 'file'=>5,'radio'=>6,'select'=>7,'submit'=>8,'range'=>9,'tel'=>10,'search'=>11,'reset'=>12,'image'=>13,'time'=>14,'date'=>15,'month'=>16,'week'=>17,'color'=>18,'url'=>19,'hidden'=>20
    ];
    const dbType = [
        'char'=> 0, 'varchar'=>1, 'int' => 2, 'bigint'=>3, 'decimal'=>4, 'float'=>5,'date' =>6,'time'=>7,'datetime'=>8,'boolean'=>9,'text'=>10,'json'=>11,'enum'=>12,'set'=>13,'blob'=>14
    ];
}
