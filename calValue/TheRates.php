<?php


require_once 'TheDates.php';


class TheRates
{
    
    private $ww_total_Period = 0;

    
    private $ww_first_z_PI_day=1;
    private $ww_sum_z_PI_day=0;
    
    private $ww_first_z_PI_per=1;
    private $ww_sum_z_PI_per=0;
    

    private $ww_data_z_R_day;                            // 当前期的息率 = 年率 /360* 本期天数
    private $ww_data_z_PI_day;                            // <1+当前期的息率>连乘积
    private $ww_data_z_R_per;                          //按整期的利率
    private $ww_data_z_PI_per;                            // <1+整期的息率>连乘积
//    private $data_z_ByDay;                            // 实际是按天算利息
    
    
    public function __construct($pp_num)
    {
        $this->initMe($pp_num);
    }
    
    
    public function __destruct() {
        $this->releaseMe();
    }
    
    private function initMe($pp_num)
    {
        //        $this->data_start_date = date_create();
        
        $this->ww_data_z_R_day = array();
        $this->ww_data_z_PI_day = array();
        $this->ww_data_z_PI_per = array();
        
        $this->ww_total_Period = $pp_num;
        
        $this->ww_first_z_PI_day=1;
        $this->ww_sum_z_PI_day=0;
        $this->ww_first_z_PI_per=1;
        $this->ww_sum_z_PI_per=0;
        
        
        $this->ww_data_z_R_per = 0;
        
        for ($i=0 ; $i<=$this->ww_total_Period+1;$i++){
            $this->ww_data_z_R_day[$i] = 0;
            $this->ww_data_z_PI_day[$i] = 1;
            $this->ww_data_z_PI_per[$i] = 1;
            //            $this->data_z_ByDay[$i] = false;
        }
        
        
    }
    
    private function releaseMe()
    {
        echo 'Destroying: ';
        //, $this->name, PHP_EOL;
        for ($i = $this->ww_total_Period + 1; $i >= 0; $i --) {
            if (is_array($this->ww_data_z_R_day) && isset($this->ww_data_z_R_day[$i]))
                unset($this->ww_data_z_R_day[$i]);
            if (is_array($this->ww_data_z_PI_day) && isset($this->ww_data_z_PI_day[$i]))
                unset($this->ww_data_z_PI_day[$i]);
            if (is_array($this->ww_data_z_PI_per) && isset($this->ww_data_z_PI_per[$i]))
                unset($this->ww_data_z_PI_per[$i]);
            // if (is_array($this->data_z_ByDay) && isset($this->data_z_ByDay[$i]))
            // unset($this->data_z_ByDay[$i]);
        }
        $this->ww_data_z_R_day = null;
        $this->ww_data_z_PI_day = null;
        $this->ww_data_z_PI_per = null;
        //        $this->data_z_ByDay = null;
        
    }
    
    
    private function set_z_R_per( $pp_real_day_rate, $pp_len )
    {

        if ($pp_len > 0) {
            $this->ww_data_z_R_per = $pp_len * $pp_real_day_rate;
        }
        if ($pp_len == 0) {
            $this->ww_data_z_R_per = 15 * $pp_real_day_rate;
        }
        if ($pp_len < 0 && $pp_len > -25 ) {
            $this->ww_data_z_R_per = 30 * (- $pp_len) * $pp_real_day_rate;
        }
        if ($pp_len <= -25 ) {
            $this->ww_data_z_R_per = 0;
        }
    }
    
    private function get_z_R_per(  ) {
        return $this->ww_data_z_R_per;
    }
    
    private function set_z_R_day($pp_num,$pp_z_R)
    { // 获取???
        if ($pp_num < 0 || $pp_num > $this->ww_total_Period + 1)
            return;
            if (is_array($this->ww_data_z_R_day) && isset($this->ww_data_z_R_day[$pp_num])) {
                $this->ww_data_z_R_day[$pp_num] = $pp_z_R;
            }
            return;
    }
    
    private function get_z_R_day($pp_num)
    { // 获取???
        if ($pp_num < 0 || $pp_num > $this->ww_total_Period + 1)
            return 0;
        if (is_array($this->ww_data_z_R_day) && isset($this->ww_data_z_R_day[$pp_num])) {
            return $this->ww_data_z_R_day[$pp_num];
        }
        return 0;
    }
    
    private function set_z_PI_day($pp_num,$pp_mult_pai)  // = false))
    { // 获取???
        if ($pp_num < 0 || $pp_num > $this->ww_total_Period + 1)
            return 1;
            
            $r = $this->get_z_R_day($pp_num);
            
            if (is_array($this->ww_data_z_PI_day) && isset($this->ww_data_z_PI_day[$pp_num])) {
                $this->ww_data_z_PI_day[$pp_num] = ( $r  + 1 ) * $pp_mult_pai;
            }
            return $this->ww_data_z_PI_day[$pp_num];  // 不用return 数字的 ????
    }
    
    
    private function get_z_PI_day($pp_num)
    { // 获取???
        if ($pp_num < 0 || $pp_num > $this->ww_total_Period + 1)
            return 1;
        if (is_array($this->ww_data_z_PI_day) && isset($this->ww_data_z_PI_day[$pp_num])) {
            return $this->ww_data_z_PI_day[$pp_num];
        }
        return 1;
    }
    
    
    private function set_z_PI_per($pp_num,$pp_mult_pai)  // = false))
    { // 获取???
        if ($pp_num < 0 || $pp_num > $this->ww_total_Period + 1)
            return 1;
        
        $r = $this->get_z_R_per();
        
        if (is_array($this->ww_data_z_PI_per) && isset($this->ww_data_z_PI_per[$pp_num])) {
            $this->ww_data_z_PI_per[$pp_num] = ( $r  + 1 ) * $pp_mult_pai;
        }
        return $this->ww_data_z_PI_per[$pp_num];  // 不用return 数字的 ????
    }
    
    
    private function get_z_PI_per($pp_num)
    { // 获取???
        if ($pp_num < 0 || $pp_num > $this->ww_total_Period + 1)
            return 1;
        if (is_array($this->ww_data_z_PI_per) && isset($this->ww_data_z_PI_per[$pp_num])) {
            return $this->ww_data_z_PI_per[$pp_num];
        }
        return 1;
    }
    
    
    
    
    
    public function getCount()
    { // ???
        return $this->ww_total_Period;
    }
    
    
    private function fix_z_R( $x, $pp_real_day_rate, $pp_days, $pp_len,$pp_useSelfDay = false)
    {
        if ($pp_useSelfDay) {
            $this->set_z_R_day($x, $pp_days * $pp_real_day_rate); // real_rate / 360.0;
            return;
        }
        
        if ($x == 1 || $x == $this->ww_total_Period) {
            $this->set_z_R_day($x, $pp_days * $pp_real_day_rate); // real_rate / 360.0;
            return;
        }
        
        if ($pp_len > 0) {
            $this->set_z_R_day($x, $pp_len * $pp_real_day_rate);
        }
        if ($pp_len == 0) {
            $this->set_z_R_day($x, 15 * $pp_real_day_rate);
        }
        if ($pp_len < 0) {
            $this->set_z_R_day($x, 30 * (- $pp_len) * $pp_real_day_rate);
        }        
    }
    
    private function cal_Rate_PI(){ // 算月还,是按期,还是按天
        
        $ll_num = $this->getCount();
        
        
        $this->ww_sum_z_PI_day = 0; // 从 2 到 第 25 个 z_pai 求和
        for ($x = $ll_num; $x >= 1; $x --) {
            $ll_mult_pai = $this->get_z_PI_day($x + 1);
            $this->set_z_PI_day($x, $ll_mult_pai);
            $this->ww_sum_z_PI_day = $this->ww_sum_z_PI_day + $ll_mult_pai; // 到 第 25 个 z_pai 求和
        }
        
        $this->ww_first_z_PI_day = $this->get_z_PI_day(1); //  第1 个 z_pai
            
            /*
            $mult_pai = 1;
            for ($x=$num; $x >= 1; $x--)
            {
                $this->sum_z_pai = $this->sum_z_pai + $mult_pai; // 从 2 到 第 25 个 z_pai 求和
                $mult_pai = ( $this->get_z_R_per()+1 )*$mult_pai ;
            }
            
            $this->first_z_pai = $mult_pai; //  第1 个 z_pai
            */
        $this->ww_sum_z_PI_per = 0;
        for ($x = $ll_num; $x >= 1; $x --) {
            $ll_mult_pai = $this->get_z_PI_per($x + 1);
            $this->set_z_PI_per($x, $ll_mult_pai);
            $this->ww_sum_z_PI_per = $this->ww_sum_z_PI_per + $ll_mult_pai; // 从 2 到 第 25 个 z_paill_   
        }
        
        $this->ww_first_z_PI_per = $this->get_z_PI_per(1); //  第1 个 z_pai
            
        
        
    }
    
    public function cal_Average_Payment($pp_total,$pp_useSelfDay) {
        if ( $pp_useSelfDay ) {
            $ll_amt = $pp_total * $this->ww_first_z_PI_day / $this->ww_sum_z_PI_day; // 求精确月供
        } else {
            $ll_amt = $pp_total * $this->ww_first_z_PI_per / $this->ww_sum_z_PI_per; // 求精确月供
        }
        //$amt = round( $amt, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供
        // $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        return $ll_amt;
    }
    
    public function cal_Period_Interest($pp_num, $pp_total_amt, $pp_useSelfDay = false){ // 算月还,是按期,还是按天
        $ll_intL = 0;
        if ($pp_num < 1 || $pp_num > $this->ww_total_Period )
            return $ll_intL;
        
        if ( $pp_useSelfDay ) { // 按天
            $ll_intD = $pp_total_amt * $this->get_z_R_day($pp_num);
        } else {
            $ll_intD = $pp_total_amt * $this->get_z_R_per(  );
        }
        
        //$amt = round( $amt, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供
        // $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        $ll_intL = intval( round( $ll_intD, 0, PHP_ROUND_HALF_UP ) ); // 求四舍五入到分月供
        return $ll_intL;
    }
    
        
    
    
    public function cal_theRates($pp_theDates,$pp_rate,$pp_useDay) {
        
        if ( (! ($pp_theDates instanceof TheDates)) || (! isset($pp_theDates)) ) {
            return;
        }
        
        $ll_len = $pp_theDates->getPeriod_Len();
        $ll_num = $pp_theDates->getCount();
        if ( $ll_num <=0 ) return;
        if ( $this->getCount() != $ll_num  ) {
            $this->releaseMe();
            $this->initMe( $ll_num);
        }
        
        
        $ll_real_day_rate = $pp_rate / 360.0;
        
        for ($x=1; $x <= $ll_num; $x++)
        {
            $ll_days = $pp_theDates->getDueDays( $x );
            
//            $this->fix_z_R( $x, $real_day_rate,$days, $len,$useDay ); // $this->d2_real_day_rate, false 按期，true 按天
            $this->set_z_R_day($x, $ll_days * $ll_real_day_rate); // real_rate / 360.0;
        }
        
        $this->set_z_R_per( $ll_real_day_rate, $ll_len );
        $this->cal_Rate_PI();
        
        
        
        
        
        //       $this->d6_period_amount = $this->d1_all_loan * $first_z_pai / $sum_z_pai; // 求精确月供
        //$this->d6_period_amount_round = round( $this->d6_period_amount, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供
        // $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        
        
        
    }
    
    public function echoData( $pp_need_table=true )
    {
        if ( $pp_need_table ) {
            //echo date_default_timezone_get();
            
            $ll_echoStr = "<table border=1 cellspacing=0 cellpadding=0>\n";
            for ($x=0; $x <= $this->ww_total_Period+1; $x++) {
                $ll_echoStr = $ll_echoStr."    <tr>\n";
                
                
                $ll_echoStr = $ll_echoStr."        <td>".$x."</td>\n";
                //            $echoStr = $echoStr."        <td>".date_format($this->data_start_date,"Y-m-d")."</td>\n";
                $ll_echoStr = $ll_echoStr."        <td>".$this->ww_data_z_PI_day[$x]."</td>\n";
                $ll_echoStr = $ll_echoStr."        <td>".$this->ww_data_z_R_day[$x]."</td>\n";
               
                $ll_echoStr = $ll_echoStr."\n";
                
                
                $ll_echoStr = $ll_echoStr."    </tr>\n";
            }
            $ll_echoStr = $ll_echoStr."</table>\n";
            $ll_echoStr = $ll_echoStr."_".$this->ww_first_z_PI_day."_".$this->ww_sum_z_PI_day."<br>\n";
            
            
            echo $ll_echoStr;
            
        }
        
    }
           
    
}