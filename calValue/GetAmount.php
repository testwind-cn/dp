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
    
    
    private $d6_Average_Amount = 0.0;
    private $d6_Average_Amountmount_round = 0;
    
    private $d_Principal = array();
    private $d_DuePrincipal = array();
    private $d_DueInterest = array();
    
    
    
    
    public function getCount()
    { // ???
        return $this->d3_total_Period;
    }
    
    
    public function __construct($num)
    {
        //        $this->data_start_date = date_create();
        
        $this->d_Principal = array();
        $this->d_DuePrincipal = array();
        $this->d_DueInterest = array();
        
        $this->d3_total_Period = $num;
        
        
        for ($i=0 ; $i<=$num+1;$i++){
            $this->d_Principal[$i] = 0;
            $this->d_DuePrincipal[$i] = 0;
            $this->d_DueInterest[$i] = 0;
            //            $this->data_z_ByDay[$i] = false;
        }
        
        
    }
    
    
    public function __destruct()
    {
        echo 'Destroying: ';
        // , $this->name, PHP_EOL;
        for ($i = $this->d3_total_Period + 1; $i >= 0; $i --) {
            if (is_array($this->d_Principal) && isset($this->d_Principal[$i]))
                unset($this->d_Principal[$i]);
            if (is_array($this->d_DuePrincipal) && isset($this->d_DuePrincipal[$i]))
                unset($this->d_DuePrincipal[$i]);
            if (is_array($this->d_DueInterest) && isset($this->d_DueInterest[$i]))
                unset($this->d_DueInterest[$i]);
            // if (is_array($this->data_z_ByDay) && isset($this->data_z_ByDay[$i]))
            // unset($this->data_z_ByDay[$i]);
        }
        $this->d_Principal = null;
        $this->d_DuePrincipal = null;
        $this->d_DueInterest = null;
        // $this->data_z_ByDay = null;
    }
    
    
    
    
    
    
    public function cal_theAmounts( $theRates, $all_loan, $useDay)
    {
        
        if ( (! ($theRates instanceof TheRates)) || (! isset($theRates)) ) {
            return;
        }
        
        $num = $theRates->getCount();
        if ( $num <=0 ) return;
        if ( $this->getCount() != $num  ) {
            $this->__destruct();
            $this->__construct($num);
        }
        
        
        if ( $all_loan < 0 ) { $all_loan = 0; }
        
        $this->d1_all_loan =  intval( round( $all_loan * 100, 0, PHP_ROUND_HALF_UP ) );

        $this->d3_total_Period = $num; // 总期数不能小于1
        
        

        $this->d_Principal[0] = $this->d1_all_loan;
        $this->d_DuePrincipal[0] = 0;
        
        
        $this->d6_Average_Amount = $theRates->cal_Average_Amount($this->d1_all_loan,$useDay);
        $this->d6_Average_Amountmount_round = intval( round( $this->d6_Average_Amount, 0, PHP_ROUND_HALF_UP ) ); // 求四舍五入到分月供

        
        // $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        
        
        for ($x=1; $x <= $num; $x++) {
            $amt = $this->d_Principal[$x-1]-$this->d_DuePrincipal[$x-1];
            $this->d_Principal[$x] =  $amt;
            $this->d_DueInterest[$x] = $theRates->cal_Period_Interest($x, $amt,$useDay );
            $this->d_DuePrincipal[$x] = $this->d6_Average_Amountmount_round - $this->d_DueInterest[$x];
        }
        
        $this->cal_last_period_due_principal();
        
        $amt = $this->d_Principal[1];
        $this->d_DueInterest[1] = $theRates->cal_Period_Interest(1, $amt,true );
        
        $x = $this->d3_total_Period;
        $amt = $this->d_Principal[$x];
        $this->d_DueInterest[$x] = $theRates->cal_Period_Interest($x, $amt,true );
        
    }
    
    
    private function cal_last_period_due_principal()
    { // 修正最后一期应还本金，如果没还完本金，全部归还。
        $num = $this->getCount();
        if ( $this->d_DuePrincipal[$num] != $this->d_Principal[$num] )
        {
            $this->d_DuePrincipal[$num] = $this->d_Principal[$num];
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
                $echoStr = $echoStr."        <td>".($this->d_Principal[$x]/100)."</td>\n";
                $echoStr = $echoStr."        <td>".($this->d_DuePrincipal[$x]/100)."</td>\n";
                $echoStr = $echoStr."        <td>".($this->d_DueInterest[$x]/100)."</td>\n";
                $echoStr = $echoStr."        <td>".(($this->d_DuePrincipal[$x]+$this->d_DueInterest[$x])/100)."</td>\n";
                
                $echoStr = $echoStr."\n";
                
                
                $echoStr = $echoStr."    </tr>\n";
            }
            $echoStr = $echoStr."</table>\n";
            
            
            echo $echoStr;
            
        }
        
    }
    
    
    
    
    
}

?>