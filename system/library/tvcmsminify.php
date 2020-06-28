<?php
class Tvcmsminify{
    public $document;
    public function __construct($registry){
        $this->document = $registry->get('document');
    }
    public function minify_html($txt){
        $place_holders = array('<!-->' => '_!--_','<pre>' => '_pre_','</pre>' => '_/pre_','<code>' => '_code_','</code>' => '_/code_','javascript"><!--'=>'javascript">_!--','--></script>'=>'--_</script>');
        $txt = strtr($txt, $place_holders);
        $txt = str_replace(array("\t",'   ','  '," \n",",\n",),array('',' ',' ',"\n",','), $txt);
        $txt = preg_replace("`>\s+<`", "><", $txt); 
        $txt = preg_replace('/<!--[^(\[|(<!))](.*)-->/Uis', '', $txt);
        $txt = strtr($txt, array_flip($place_holders));
        return $txt;
    }
}