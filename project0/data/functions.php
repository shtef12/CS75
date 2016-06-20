<?php
    //adds the categories to the index page
    function addCategories($xmlObject){   ?>
    <table class="tableCenter">
<?php   foreach($xmlObject as $category){   
        //add a link to the category's web page ?>
        <tr>
            <td>
            <!--add the link to the item's page -->
<?php       echo "<a href="."Items.php?item=".$category['name'].">".$category['name']."</a>"; ?>
           
            </td>
        </tr>
<?php   }    ?>
    </table>
<?php }
?>
    
<?php function getCategoryIndex($xmlObject, $categoryName){
        $index = 0;
        foreach($xmlObject as $category){
            if($category['name'] == $categoryName){
                //echo "found the category";
                return $index;
            }
            $index += 1;
        }
    }
?>

<?php
    class MenuItem{
        public $name;
        public $price;
    }
?>
