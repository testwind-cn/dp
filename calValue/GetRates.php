<?php


require_once 'GetDates.php';


class TheRates
{
    
    private $d3_total_Period = 0;

    
    private $first_z_pai=1;
    private $sum_z_pai=0;
    

    private $data_z_R;                            // 本期本息率 = 1 + 年率 /360* 本期天数
    private $data_z_pai;                            // <本息率>连乘积
    private $data_z_R_per;  //期利率
//    private $data_z_ByDay;                            // 实际是按天算利息
    
    
    public function __construct($num)
    {
        //        $this->data_start_date = date_create();
        
        $this->data_z_R = array();
        $this->data_z_pai = array();
        
        $this->d3_total_Period = $num;
        
        $this->first_z_pai=1;
        $this->sum_z_pai=0;
        $this->data_z_R_per = 0;
        
        for ($i=0 ; $i<=$this->d3_total_Period+1;$i++){
            $this->data_z_R[$i] = 0;
            $this->data_z_pai[$i] = 1;
//            $this->data_z_ByDay[$i] = false;
        }
        
        
    }
    
    
    public function __destruct() {
        echo 'Destroying: ';
        //, $this->name, PHP_EOL;
        for ($i = $this->d3_total_Period + 1; $i >= 0; $i --) {
            if (is_array($this->data_z_R) && isset($this->data_z_R[$i]))
                unset($this->data_z_R[$i]);
            if (is_array($this->data_z_pai) && isset($this->data_z_pai[$i]))
                unset($this->data_z_pai[$i]);
//            if (is_array($this->data_z_ByDay) && isset($this->data_z_ByDay[$i]))
//                unset($this->data_z_ByDay[$i]);
        }
        $this->data_z_R = null;
        $this->data_z_pai = null;
//        $this->data_z_ByDay = null;
    }
    
    
    private function set_z_R_per( $real_day_rate, $len )
    {

        if ($len > 0) {
            $this->data_z_R_per = $len * $real_day_rate;
        }
        if ($len == 0) {
            $this->data_z_R_per = 15 * $real_day_rate;
        }
        if ($len < 0) {
            $this->data_z_R_per = 30 * (- $len) * $real_day_rate;
        }
    }
    
    private function get_z_R_per(  ) {
        return $this->data_z_R_per;
    }
    
    private function get_z_R($num)
    { // 获取???
        if ($num < 0 || $num > $this->d3_total_Period + 1)
            return 1;
        if (is_array($this->data_z_R) && isset($this->data_z_R[$num])) {
            return $this->data_z_R[$num];
        }
        return 1;
    }
    
    private function set_z_R($num,$z1b)
    { // 获取???
        if ($num < 0 || $num > $this->d3_total_Period + 1)
            return;
        if (is_array($this->data_z_R) && isset($this->data_z_R[$num])) {
            $this->data_z_R[$num] = $z1b;
        }
        return;
    }
    
    
    private function get_z_pai($num)
    { // 获取???
        if ($num < 0 || $num > $this->d3_total_Period + 1)
            return 1;
        if (is_array($this->data_z_pai) && isset($this->data_z_pai[$num])) {
            return $this->data_z_pai[$num];
        }
        return 1;
    }
    
    private function set_z_pai($num,$mult_pai)
    { // 获取???
        if ($num < 0 || $num > $this->d3_total_Period + 1)
            return 1;
        if (is_array($this->data_z_R) && isset($this->data_z_R[$num])) {
            $r = $this->data_z_R[$num];
        }
        if (is_array($this->data_z_pai) && isset($this->data_z_pai[$num])) {
            $this->data_z_pai[$num] = ( $r  + 1 ) * $mult_pai;
        }
        return $this->data_z_pai[$num];  // 不用return 数字的 ????
    }
    
    
    
    public function getCount()
    { // ???
        return $this->d3_total_Period;
    }
    
    
    private function fix_z_R( $x, $real_day_rate, $days, $len,$useSelfDay = false)
    {
        if ($useSelfDay) {
            $this->set_z_R($x, $days * $real_day_rate); // real_rate / 360.0;
            return;
        }
        
        if ($x == 1 || $x == $this->d3_total_Period) {
            $this->set_z_R($x, $days * $real_day_rate); // real_rate / 360.0;
            return;
        }
        
        if ($len > 0) {
            $this->set_z_R($x, $len * $real_day_rate);
        }
        if ($len == 0) {
            $this->set_z_R($x, 15 * $real_day_rate);
        }
        if ($len < 0) {
            $this->set_z_R($x, 30 * (- $len) * $real_day_rate);
        }        
    }
    
    private function cal_PerRate($useSelfDay = false){ // 算月还,是按期,还是按天
        
        $num = $this->getCount();
        
        $this->sum_z_pai = 0; // 从 2 到 第 25 个 z_pai 求和
        
        
        if ( $useSelfDay ) {
            
            for ($x=$num; $x >= 1; $x--)
            {
                $mult_pai = $this->get_z_pai( $x+1 );
                $this->set_z_pai( $x,$mult_pai );
                $this->sum_z_pai = $this->sum_z_pai + $mult_pai; // 从 2 到 第 25 个 z_pai 求和
            }
            
            $this->first_z_pai = $this->get_z_pai(1); //  第1 个 z_pai
            
        } else {
            
            $mult_pai = 1;
            for ($x=$num; $x >= 1; $x--)
            {
                $this->sum_z_pai = $this->sum_z_pai + $mult_pai; // 从 2 到 第 25 个 z_pai 求和
                $mult_pai = ( $this->get_z_R_per()+1 )*$mult_pai ;
            }
            
            $this->first_z_pai = $mult_pai; //  第1 个 z_pai
            
        }
        
    }
    
    public function cal_Period_Amount($total) {
        $amt = $total * $this->first_z_pai / $this->sum_z_pai; // 求精确月供
        //$amt = round( $amt, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供
        // $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        return $amt;
    }
    
    public function cal_Period_Interest($num, $total_amt, $per_amt,$useSelfDay = false){ // 算月还,是按期,还是按天
        if ($num < 1 || $num > $this->d3_total_Period )
            return 0;
        
        if ( $useSelfDay ) { // 按天
            $intv = $total_amt * $this->get_z_R($num);
            $intv = round( $intv, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供
        } else {
            $intv = $total_amt * $this->get_z_R_per(  );
            $intv = round( $intv, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供            
        }
        
        //$amt = round( $amt, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供
        // $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        return $intv;
    }
    
        
    
    
    public function cal_theRates($theDates,$rate) {
        
        if ( (! ($theDates instanceof TheDates)) || (! isset($theDates)) ) {
            return;
        }
        
        $len = $theDates->getPeriod_Len();
        $num = $theDates->getCount();
        if ( $num <=0 ) return;
        if ( $this->getCount() != $num  ) {
            $this->__destruct();
            $this->__construct($num);
        }
        
        
        $real_day_rate = $rate / 360.0;
        
        for ($x=1; $x <= $num; $x++)
        {
            $days = $theDates->getDueDays($num);
            
            $this->fix_z_R( $x, $real_day_rate,$days, $len,false ); // $this->d2_real_day_rate, false 按期，true 按天
        }
        
        $this->set_z_R_per( $real_day_rate, $len );
        $this->cal_PerRate(false);
        
        
        
        
        
        //       $this->d6_period_amount = $this->d1_all_loan * $first_z_pai / $sum_z_pai; // 求精确月供
        //$this->d6_period_amount_round = round( $this->d6_period_amount, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供
        // $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        
        
        
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
                $echoStr = $echoStr."        <td>".$this->data_z_pai[$x]."</td>\n";
                $echoStr = $echoStr."        <td>".$this->data_z_R[$x]."</td>\n";
               
                $echoStr = $echoStr."\n";
                
                
                $echoStr = $echoStr."    </tr>\n";
            }
            $echoStr = $echoStr."</table>\n";
            $echoStr = $echoStr."_".$this->first_z_pai."_".$this->sum_z_pai."<br>\n";
            
            
            echo $echoStr;
            
        }
        
    }
           
    
}