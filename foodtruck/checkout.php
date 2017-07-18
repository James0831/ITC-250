<?php
//checkout2.php
/*
 * @package Food Truck
 * @author Anu Slorah <anuslorah@hotmail.com>
 * @author James Carroll <jdcarroll08@gmail.com>
 * @author Zak Brinlee <zbrinlee@gmail.com>
 * @version 0.1 2017/07/18
 * @link http://programmingbyzakb.com/itc250/sm17/p2/checkout2.php
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see items.php
 * @see cart.php - For extra credit 
 * @todo Extra credit if desired
*/
include 'items.php';
include 'cart.php';
?>

                <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post">

                    <!-- Iterate across each food item in the menu array. -->
                    <?php 
                        foreach($items as $item){
                            echo '<div class=menu_item>	
                                    <label>
                                        <h3>'.$item->Name.'</h3>
                                        <p>'.$item->Description.'</p>
                                        <select name="'.$item->Name.'" required title="0" tabindex="15">
                                                <option value="0">Please choose the quantity:</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                        </select>
                                    </label>
                                </div>';
                                
                            if(isset($_POST[str_replace(' ','_',$item->Name)])){
                                if($_POST[str_replace(' ','_',$item->Name)] > 0){
                                    $item->Quantity = intval($_POST[str_replace(' ','_',$item->Name)]);
                                }
                            }
                            
                                 
                            }
                                            
             
                    ?>
                        
                        <div class="submit">
                        <input type="Submit" name="submit" value="Place Your Order" />
                        </div> 
                     
                     </form>
                         <?php
                        
                 foreach($items as $item)
                  {
                    if($item->Quantity > 0)
                    {
                       $output = $item->Name;
                       $output .=' '. $item->Quantity.' x $'.money_format('%!.2n' ,$item->Price);
                       $output .= ' = ';
                       $output .= '$'.money_format('%!.2n',($item->Quantity*$item->Price)).'</br>';
                       echo $output;
                    }
                }
                    ?>