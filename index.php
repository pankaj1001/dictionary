<?php

  function mkurl($word){
    $v="http://www.dictionary.com/browse/".$word."?s=t";
    return $v;
  }



  function curlget($url){
    $curl=curl_init();
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
     curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
     curl_setopt($curl, CURLOPT_URL, $url);
     $result=curl_exec($curl);
     curl_close($curl);
     return $result;
  }

  $definition=array();

  function pathobject($param){
    $doc_object=new DOMDocument();
    @$doc_object->loadHTML($param);
    $xmlpath=new DOMXPath($doc_object);
    return $xmlpath;
  }

  $link=mkurl($_POST['word']);


  $page=curlget($link);

  $pagepath=pathobject($page);

  $defi = $pagepath->query('//div[@class="def-content"]');

  if($defi->length > 0){
    for($i=0;$i<$defi->length;$i++){
      $definition['def'][]=$defi->item($i)->nodeValue;
    }
  }

 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Dictionary</title>
     <link rel="stylesheet" href="style.css">
   </head>
   <body>
     <form class="" action="index.php" method="post">
       <label for="word">Search:</label>
       <input type="text" name="word" value="" placeholder="Enter Word"/>
       <button type="submit" name="button">Submit</button>
     </form>
     <br/>
       <div class="container">
       <?php
       if(!empty($definition)){
           foreach($definition['def'] as $val){
         //  $val=strip_tags($val);
            echo '<p>--'.$val."</p>";
           }
         }
         else{
           echo 'Not a Word to Define';
         }

        ?>
      </div>
   </body>
 </html>
