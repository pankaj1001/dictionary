<?php
$word = $_POST['word'];
$source= file_get_contents('http://www.dictionary.com/browse/'.$word.'?s=t');

$start=strpos($source,'<div class="def-content">');
$array = array();
$count =0;
while($start && $count<5){
  $source=substr($source,$start);
  $end=strpos($source,'</div>');
  $array[]=substr($source,0,$end);
  $source=substr($source,$end);
  $start=strpos($source,'<div class="def-content">');
  $count+=1;
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <form class="input" action="index.php" method="POST">
      <label for="word"><span><h1>Search:</h1><span></label>
      <input type="text" name="word" value=""/placeholder="Enter Your Word">
      <input type="submit" name="submit" value="Submit"/>
    </form>
    <br/>
    <div class="background">
      <?php
      echo '<h1>'.$word.' --</h1>';
      if(!empty($array)){
        foreach($array as $val){
        $val=strip_tags($val);
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
