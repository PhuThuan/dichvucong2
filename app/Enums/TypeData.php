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
        'text' => 0, 'number' =>1 , 'checkbox' => 2, 'email' => 3,'password'=>4, 'file'=>5,'radio'=>6,'select'=>7,'submit'=>8,'range'=>9,'tel'=>10,'search'=>11,'reset'=>12,'image'=>13,'time'=>14,'date'=>15,'month'=>16,'week'=>17,'color'=>18,'url'=>19,'hidden'=>20,
        0 => 'text' ,1 => 'number' ,2 => 'checkbox' ,3 => 'email' ,4=>'password' ,5 => 'file',6 => 'radio' ,7 => 'select' ,8 => 'submit' ,9 => 'range' ,10 => 'tel' ,11 => 'search' ,12=>'reset' ,13 => 'image' ,14 => 'time',15=> 'date',16=>'month',17=>'week',18=>'color',19=>'url',20=> 'hidden','address' => 21, 21=> 'address'
    ];
    const dbType = [
        'char'=> 0, 'varchar'=>1, 'int' => 2, 'bigint'=>3, 'decimal'=>4, 'float'=>5,'date' =>6,'time'=>7,'datetime'=>8,'boolean'=>9,'text'=>10,'json'=>11,'enum'=>12,'set'=>13,'blob'=>14,
        0=>'char',1=>'varchar',2=>'int',3=>'bigint',4=>'decimal',5=>'float',6=>'date',7=>'time',8=>'datetime',9=>'boolean',10=>'text',11=>'json',12=>'enum',13=>'set',14=>'blob'
    ];
    const status=[
        'enable'=>1,1=>'enable',0=>'disable','disable'=>0,
    ];
}
