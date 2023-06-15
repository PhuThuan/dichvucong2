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
    const roleUser =[0=>'user',1=>'admin'];
    const htmlType = [
    'text'=>0, 'number' => 1, 'checkbox'  => 2,  'email' =>3, 'password'=>4,  'file'=>5,  'radio'=>6,  'submit'=>7, 'range'=>8, 'tel'=>9, 'search'=>10,  'reset'=>11,  'image'=>12,  'time'=>13,  'date'=>14, 'month'=>15, 'week'=>16, 'color'=>17,'url'=>18, 'hidden'=>19
    ];
    const dbType = [
     'char'=>0, 'varchar'=>1, 'int'=>2, 'bigint'=>3, 'decimal'=>4, 'float'=>5, 'date'=>6, 'time'=>7, 'datetime'=>8,  'boolean'=>9,  'text'=>10, 'json'=>11,  'enum'=>12,  'set'=>13,  'blob=>14'
    ];
}
