<?php
/**
* MySQL Class 
* Author : AmmAr Abdelhamied <flashpack@gmail.com>
**/
class MySQL{
	private $result = NULL;
	private $link = NULL;
	private static $instance = NULL; 
	public $results;
	public static function getInstance(array $config=array()){
		if(self::$instance===NULL){
			self::$instance=new self($config) ; 
		}
		return self::$instance ; 
	}
	function __construct(array $config=array())
	{
		list($dbHost,$dbUser,$dbPass,$dbName)=$config;
		if($this->dbLink = mysqli_connect($dbHost,$dbUser, $dbPass)){
			isset($dbName) and $this->select_db($dbName);
			return $this->dbLink  ;
		}else{
		   $this->error(mysqli_error($this->dbLink));
		   return false ; 
		}
	}
	/**
	* select a mysql database  
	* @param string $dbName  Database name
	* @return void
	**/
	function select_db($dbName){
		mysqli_select_db($this->dbLink,$dbName );
		mysqli_query($this->dbLink,"SET NAMES 'utf8'");
	}
	
	/**
	* Excute MySQL Query 
	* @param string $queryStatment is the mysql statement to be excuted
	* @param boolean $fetch if true the function call $this->fetchArray to fetch the result
	* @param boolean $count if true counts the results 
	* @param boolean|integer $limit if greater than 0 it limits the fetched result
	* @return array|rescource
	**/
	
	function query($queryStatment,$fetch=true,$count=false,$limit=0,$string=true)
	{
		$query=mysqli_query($this->dbLink,$queryStatment)or $this->error(mysqli_error($this->dbLink));
		if($limit!=0){
			$numrows = mysqli_num_rows($query); 
			$nav=$this->pagination($numrows,$limit,$string);
			$result=mysqli_query($this->dbLink,$queryStatment.' LIMIT '.$nav['start'].' , '.$limit)or $this->error(mysqli_error($this->dbLink));	
			$fetchedArray=$this->fetchArray($result,$count);
			$fetchedArray['nav']=$nav;
			$fetchedArray['all_count']=$numrows;
			return $fetchedArray;
		}elseif($fetch){
			return $this->fetchArray($query,$count);
		}else{
			return $query;
		}
		
	}
	/**
	* fetch mysql return into an array
	* @param rescource $query mysql query rescource
	* @param boolean $count if true counts the results
	* @return array
	**/

	function fetchArray($query,$count=false)
	{	
		while($result_array=mysqli_fetch_array($query)){
				$rows[]=$result_array;
		}	
		if($count!==false){
			$results['count']=mysqli_num_rows($query);
		}
		$results['rows']=$rows ; 
		$this->results=$results;
		return $results;
		
	}
	
	function pagination($numrows,$limit,$string)
	{
		$pages=ceil($numrows/$limit);
		$page=($_GET['page'])?$_GET['page']<($pages+1)?$_GET['page']:1:1;
		$pages_array['prev']=$page!=1 && $string?'<a rel="'.($page-1).'" href="'.get_url('page',$page-1).'">Previous</a>':'';
		for($i=1;$i<=$pages;$i++){
			if($string){
				if($i==$page){
					$pages_array[$i]='['.$i.'] ';
				}else{
					$pages_array[$i]='<a rel="'.$i.'" href="'.get_url('page',$i).'">'.$i.'</a> ';
				}
			}else{
				$pages_array[$i]=$i;
			}
		}
		$pages_array['next']=($pages!=0 && $page!=$i-1 && $string)?'<a rel="'.($page+1).'" href="'.get_url('page',$page+1).'">Next</a>':'';
		return array('string'=>$string?implode(' ',$pages_array):$pages_array,'start'=>($page-1)*$limit);
		
	}

	function error($error)
	{
		if($error && config::$debug){
			echo '<strong> Database Error: </strong>'.$error.'<br />';
		}
	}
		
	function order($table,$ids,$idField='id',$orderField='order')
	{
		$query=$this->query("select (select `$orderField` from `$table` where `$idField`='$ids[0]'),(select `$orderField` from `$table` where `$idField`='$ids[1]')");
		$order[0]=$query['rows'][0][0];
		$order[1]=$query['rows'][0][1];
		if(is_numeric($ids[0],$ids[1])){
			$this->query("update `$table` set `$orderField`='$order[1]' where `$idField`='$ids[0]'",false);
			$this->query("update `$table` set `$orderField`='$order[0]' where `$idField`='$ids[1]'",false);
		}
		$orderID=$query['rows'][0][$orderField];

	}//end function order
		
	function close(){
		@mysqli_close($this->dbLink)or $this->error(mysqli_error($this->dbLink));	
	}
	function __destruct()
	{	if ($this->result){
			mysqli_free_result($this->result);
		}
	}
}
?>