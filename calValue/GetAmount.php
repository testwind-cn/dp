<?php


require_once 'calValue/GetRates.php';
require_once 'calValue/GetDates.php';



class TheAmounts
{
    // 1-1098按设置固定天（ 多期、一期），
    // 0按半月，-1按月，-2双月，-3三月，-4四月，-5五月，-6六月、-7七月、-8八月、-9九月、-10十月、-11十月、-12一年、（ 多期、一期）
    // -13 .. -24两年，（ 多期、一期）
    // -25按指定天,（ 多期、一期）
    
    private $d1_all_loan = 12000;
    private $d3_total_Period = 6;
    
    
    private $d6_period_amount = 0.0;
    private $d6_period_amount_round = 0;
    
    private $d_Amounts = array();
    private $d_DueAmounts = array();
    private $d_DueInterests = array();
    
    
    
    
    public function getTotal()
    { // ???
        return $this->d3_total_Period;
    }
    
    
    public function __construct($num)
    {
        //        $this->data_start_date = date_create();
        
        $this->d_Amounts = array();
        $this->d_DueAmounts = array();
        $this->d_DueInterests = array();
        
        $this->d3_total_Period = $num;
        
        
        for ($i=0 ; $i<=$num+1;$i++){
            $this->d_Amounts[$i] = 0.0;
            $this->d_DueAmounts[$i] = 0.0;
            $this->d_DueInterests[$i] = 0.0;
            //            $this->data_z_ByDay[$i] = false;
        }
        
        
    }
    
    
    public function __destruct()
    {
        echo 'Destroying: ';
        // , $this->name, PHP_EOL;
        for ($i = $this->d3_total_Period + 1; $i >= 0; $i --) {
            if (is_array($this->d_Amounts) && isset($this->d_Amounts[$i]))
                unset($this->d_Amounts[$i]);
            if (is_array($this->d_DueAmounts) && isset($this->d_DueAmounts[$i]))
                unset($this->d_DueAmounts[$i]);
            if (is_array($this->d_DueInterests) && isset($this->d_DueInterests[$i]))
                unset($this->d_DueInterests[$i]);
            // if (is_array($this->data_z_ByDay) && isset($this->data_z_ByDay[$i]))
            // unset($this->data_z_ByDay[$i]);
        }
        $this->d_Amounts = null;
        $this->d_DueAmounts = null;
        $this->d_DueInterests = null;
        // $this->data_z_ByDay = null;
    }
    
    
    
    
    
    
    public function calPeriodAmount( $theRates, $all_loan )
    {
        
        if ( (! ($theRates instanceof TheRates)) || (! isset($theRates)) ) {
            return;
        }
        
        $num = $theRates->getTotal();
        if ( $num <=0 ) return;
        if ( $this->getTotal() != $num  ) {
            $this->__destruct();
            $this->__construct($num);
        }
        
        
        if ( $all_loan < 0 ) { $all_loan = 0; }
        
        $this->d1_all_loan = $all_loan;

        $this->d3_total_Period = $num; // 总期数不能小于1
        
        

        $this->d_Amounts[0] = $this->d1_all_loan;
        $this->d_DueAmounts[0] = 0;
        
        
        $this->d6_period_amount = $theRates->cal_Period_Amount($all_loan);
        $this->d6_period_amount_round = round( $this->d6_period_amount, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供

        
        // $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        
        
        for ($x=1; $x <= $this->d3_total_Period; $x++) {
            $amt = $this->d_Amounts[$x-1]-$this->d_DueAmounts[$x-1];
            $this->d_Amounts[$x] =  $amt;
            $this->d_DueInterests[$x] = $theRates->cal_Period_Interest($x, $amt,false );
            $this->d_DueAmounts[$x] = $this->d6_period_amount_round - $this->d_DueInterests[$x];
        }
        
        $this->cal_last_period_due_principal();
        
        $amt = $this->d_Amounts[1];
        $this->d_DueInterests[1] = $theRates->cal_Period_Interest(1, $amt,true );
        
        $x = $this->d3_total_Period;
        $amt = $this->d_Amounts[$x];
        $this->d_DueInterests[$x] = $theRates->cal_Period_Interest($x, $amt,false );
        
    }
    
    
    private function cal_last_period_due_principal()
    { // 修正最后一期应还本金，如果没还完本金，全部归还。
        $num = $this->getTotal();
        if ( $this->d_DueAmounts[$num] < $this->d_Amounts[$num] )
        {
            $this->d_DueAmounts[$num] = $this->d_Amounts[$num];
        }
    //    $this->data_due_amount = $this->data_due_principal + $this->data_due_interest;
    }
    
    
    public function echoData( $need_table=true )
    {
        if ( $need_table ) {
            //echo date_default_timezone_get();
            
            $echoStr = "<table border=1 cellspacing=0 cellpadding=0>\n";
            for ($x=0; $x <= $this->d3_total_Period+1; $x++) {
                $echoStr = $echoStr."    <tr>\n";
                
                
                $echoStr = $echoStr."        <td>".$x."</td>\n";
                //            $echoStr = $echoStr."        <td>".date_format($this->data_start_date,"Y-m-d")."</td>\n";
                $echoStr = $echoStr."        <td>".$this->d_Amounts[$x]."</td>\n";
                $echoStr = $echoStr."        <td>".$this->d_DueAmounts[$x]."</td>\n";
                $echoStr = $echoStr."        <td>".$this->d_DueInterests[$x]."</td>\n";
                $echoStr = $echoStr."        <td>".($this->d_DueAmounts[$x]+$this->d_DueInterests[$x])."</td>\n";
                
                $echoStr = $echoStr."\n";
                
                
                $echoStr = $echoStr."    </tr>\n";
            }
            $echoStr = $echoStr."</table>\n";
            
            
            echo $echoStr;
            
        }
        
    }
    
    
    
    
    
}

?>