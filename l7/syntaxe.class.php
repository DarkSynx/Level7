<?php

namespace l7\elements;

class syntaxe {

	const SPECIAL_SYNTAXE		= false;
	const SPECIAL_SYNTAXE_CHAR	= '';
	
	public $return_pre_initialisation = '';
	
	public $return_start = '';
	public $return_end = '';
	

	
	public $tabulations 	= '';
	public $php_eol_ctr 	= '';
	
	protected $_tab_actived = false;
	protected $_encaps = 0;
	
	protected $_match_raw 		= '';
	protected $_match_func 		= '';
	protected $_match_sub_func 	= '';
	protected $_match_hook 		= '';
	protected $_match_bracket 	= '';
	protected $_match_rafter 	= '';
	protected $_match_curly 	= '';
	
	protected $_del_match_raw 		= false;
	protected $_del_match_func 		= false;
	protected $_del_match_hook 		= false;
	protected $_del_match_bracket 	= false;
	protected $_del_match_rafter 	= false;
	protected $_del_match_curly 	= false;
	
	
	protected $_change_match_raw 		= '';
	protected $_change_match_func 		= '';
	protected $_change_match_hook 		= '';
	protected $_change_match_bracket 	= '';
	protected $_change_match_rafter 	= '';
	protected $_change_match_curly 		= '';	
	
	protected $_use_post_work 		= false;
	
	
	protected $_sub_function 	= false;

	protected $_my_parent;

	protected $_global_exploite;

	public function __construct( $global_exploite ) {
		$this->_global_exploite = $global_exploite;
	}
	
	public function gen_start() : string {	
		return 	$this->return_start == '' ? '' : $this->tabulations . $this->return_start . $this->php_eol_ctr;
	}
	
	public function gen_end() : string{	
		return 	($this->return_end == '' ? '' : ($this->php_eol_ctr . $this->tabulations . $this->return_end));
	}
	
	public function gen_endx() : string{	
		return 	($this->return_end == '' ? '' : ($this->tabulations . $this->return_end ));
	}	
	
	public function gest_gen_contener_matchesG_ternair( &$l7_obj_used, &$thematchesg ) : void {
		
		/* load la méthode de votre objet 
		par exemple html->get_replace_contener_start() 
		*/
		$this->get_replace_contener_start();
		
		/* on doit générer $end par ce que sinon celui-ci peut ce retrouver
		avec les valeur d'une autre analyse par $l7_obj_used->exploder_syntaxe
		*/
		$end = $this->gen_end();
		$endx = $this->gen_endx();
		
		/* ici cette fonctionalité prépare $thematchesg qui est 
		$matchesG[0][key] ou val avec gen_start comme debut 
		exemple <debut> et end </fin>
		entre les deux $l7_obj_used->exploder_syntaxe
		permet de continuer l'analyse des données à incorporer
		cela permet aussi de switcher sur 2 cas de figure 
		la présentation <debut contenu > et <debut> contenu</fin>
		*/

		$gen = ( isset($l7_obj_used->sub_matches[5]) ? 
		($this->gen_start() . 
			(
				($l7_obj_used->sub_matches[5] == '') ? 
				$endx : 
				$l7_obj_used->exploder_syntaxe( $this->_match_curly, $this, ($this->_encaps + 1), $this->tabulations ) . $end
			)
		): ($this->tabulations . $this->get_replace() ));
		
		if ($this->_use_post_work) {
			$gen = $this->post_work();
		}
		
		$thematchesg .= $gen;
		
	}
	
	public function pre_initialisation( &$thisisit = null, &$matchesG, &$subfonction = '', &$parent = null, &$encaps, $tab_actived) : bool {

		
		if (get_class($this) == ($thisisit::NAMESPC . 'notexcute') ) { $matchesG = ''; return false; }


			$this->_encaps 		= &$encaps;
			$this->_tab_actived = &$tab_actived;
			$this->php_eol_ctr  = &$thisisit->cphp_eol;
			$this->_my_parent	= &$parent;
			
			$this->tabulations  = ($tab_actived ? str_repeat("\t", $encaps) : '');
			
			
			//var_dump($matche);
			$this->_match_raw 		 = &$thisisit->sub_matches[0] ?? null;
			$this->_match_func 		 = &$thisisit->sub_matches[1] ?? null;
			$this->_match_hook 		 = &$thisisit->sub_matches[2] ?? null;
			$this->_match_bracket 	 = &$thisisit->sub_matches[3] ?? null;
			$this->_match_rafter 	 = &$thisisit->sub_matches[4] ?? null;
			$this->_match_curly 	 = &$thisisit->sub_matches[5] ?? null;
			

			if ($subfonction) {
				$this->_match_func 	 =  &$subfonction;
				$this->_sub_function = true;
			} else {
				$this->_sub_function = false;
			}
			
			
			$matchesG = $this->initialisation();
			

			
			
			if ($this->_del_match_raw) 		{$this->_match_raw		= ''; $thisisit->sub_matches[0] = '';}
			if ($this->_del_match_func) 	{$this->_match_func 	= ''; $thisisit->sub_matches[1] = '';}
			if ($this->_del_match_hook) 	{$this->_match_hook 	= ''; $thisisit->sub_matches[2] = '';}
			if ($this->_del_match_bracket) 	{$this->_match_bracket 	= ''; $thisisit->sub_matches[3] = '';}
			if ($this->_del_match_rafter) 	{$this->_match_rafter 	= ''; $thisisit->sub_matches[4] = '';}
			if ($this->_del_match_curly) 	{$this->_match_curly 	= ''; $thisisit->sub_matches[5] = '';}

			if ($this->_change_match_raw 		!= '') 	{$this->_match_raw		= $this->_change_match_raw 		; $thisisit->sub_matches[0] = &$this->_change_match_raw 	;}
			if ($this->_change_match_func 		!= '') 	{$this->_match_func 	= $this->_change_match_func 	; $thisisit->sub_matches[1] = &$this->_change_match_func 	;}
			if ($this->_change_match_hook 		!= '') 	{$this->_match_hook 	= $this->_change_match_hook 	; $thisisit->sub_matches[2] = &$this->_change_match_hook 	;}
			if ($this->_change_match_bracket 	!= '') 	{$this->_match_bracket 	= $this->_change_match_bracket	; $thisisit->sub_matches[3] = &$this->_change_match_bracket ;}
			if ($this->_change_match_rafter 	!= '')  {$this->_match_rafter 	= $this->_change_match_rafter 	; $thisisit->sub_matches[4] = &$this->_change_match_rafter  ;}
			if ($this->_change_match_curly 		!= '') 	{$this->_match_curly 	= $this->_change_match_curly 	; $thisisit->sub_matches[5] = &$this->_change_match_curly 	;}
			
			
			$this->gest_gen_contener_matchesG_ternair( $thisisit, $matchesG );

		return true;
	}
	
	public function get_gtable() {	
		return $this->_global_exploite->get_table_global();
	}

	public function add_gtable($val='',$key='') {	
		return $this->_global_exploite->add_item_table_global($val,$key);
	}	

	public function rmv_gtable($key='') {	
		return $this->_global_exploite->remove_item_table_global($key);
	}

	protected function analyse(&$data = '', &$tab = array()) {
		
	 //$data = 'var:test == var:test1 and var:test2 == var:test3 or var:test4 != var:test5';
	 $datafmt = explode('[#]', str_replace(['or','and'],'[#]',$data));
	 $count_data = count($datafmt) - 1;
	 $logique = array();
	 $b = 0;
	 for($a=0, $b=0; $a <  $count_data; $a = $b) {
		$b = strpos($data , chr(32) . 'or' . chr(32), $a);
		$logique[$b] = 'or';
	 }
	 for($a=0, $b=0; $a <  $count_data; $a = $b) {
		$b = strpos($data , chr(32) . 'and' . chr(32), $a);
		$logique[$b] = 'and';
	 }

	 ksort($logique);
	 $logique = array_values($logique);

	 foreach($datafmt as &$val){
		
		$detect = (
		 (strpos($val, '==') !== false) ? '==' : 
		((strpos($val, '!=') !== false) ? '!=' : 
		((strpos($val, '>=') !== false) ? '>=' : 
		((strpos($val, '<=') !== false) ? '<=' : 
		((strpos($val, '<>') !== false) ? '<>' : 
		((strpos($val, '>' ) !== false) ? '>'  : 
		((strpos($val, '<' ) !== false) ? '<'  :
		((strpos($val, '%' ) !== false) ? '%'  : FALSE ))))))));
		
		if($detect !== FALSE) {
			
			//echo "\tok:1". PHP_EOL;
			$p = explode('[#]', str_replace(['===','!==','==','!=','>=','<=','<>','>','<','%'],'[#]',$val));
			$p = array_map('trim', $p);
			//print_r($p);
			
			foreach($p as &$v) {
				$this->type_gen($v, $tab);
			}
			
			
			
			//echo "\t\t\t\tok:4 > " . $detect . PHP_EOL;
			
			switch($detect) {
				case '===':
					$val = ($p[0] === $p[1]);
				break;
				case '!==':
					$val = ($p[0] !== $p[1]);
				break;
				case '==':
					$val = ($p[0] == $p[1]);
					//echo "\t\t\t\t\tok:5 > " . $p[0] . '==' . $p[1] . '->' . $rt . PHP_EOL;
				break;
				case '!=':
					$val = ($p[0] != $p[1]);
				break;
				case '>=':
					$val = ($p[0] >= $p[1]);
				break;
				case '<=':
					$val = ($p[0] <= $p[1]);
				break;
				case '<>':
					$val = ($p[0] <> $p[1]);
				break;
				case '>':
					$val = ($p[0] > $p[1]);
				break;
				case '<':
					$val = ($p[0] < $p[1]);
				break;
				case '%':
					$val = ($p[0] % $p[1]);
				break;
			}

		}

	 }
	 
	 $retenu = null;
	 $p1 = null;
	 $p2 = null;
	 $cl = null;
	 $cli = 0;
	 foreach($datafmt as &$val){
			if(is_null($p1)) { $p1 = $val; }
			else { $p2 = $val; }
			$cl = $logique[$cli];
			if( !is_null($p1) and !is_null($p2) and !is_null($cl)) {
				
				if($cl == 'or') {
					$p1 = ($p1 || $p2);
				}
				else {
					$p1 = ($p1 && $p2);
				}
				
				$p2 = null;
				$cl = null;
				$cli++;
			}
	 }
	 
	//print_r($datafmt);
	 
	 return $p1;

	}	
	
	protected function type_gen(&$v,&$tab) {
		
					
					$type = strstr($v,':',true);
					
					
					if($type !== false) {
							$valx = trim(substr(strstr($v,':'),1));
							//echo "\t\tok:2 > " . $type . PHP_EOL;
							
							switch($type){			
								case 'VAR':
								case 'var':	
									//echo "\t\t\tok:3". PHP_EOL;
									$v = $tab[$valx];
									//print_r($p);
									//echo '-------------' . PHP_EOL;
								break;
								case 'INT':								
								case 'int':			
									$v = (int) $valx;			
								break;
								case 'BOOL':
								case 'bool':			
									$v = (bool) $valx;			
								break;
								case 'FLOAT':
								case 'float':			
									$v = (float) $valx;			
								break;
								case 'ARRAY':
								case 'array': // [val1,val2,val3...]
										$var_array = explode(',',$valx);
										$var_array = array_map('trim',$var_array);
										$array_gen = array();
										foreach ($var_array as $val) {
												if( strstr($val, '=>') !== false ) {
													$xp = explode('=>', $val);
													$this->type_gen($xp[1],$tab);
													$array_gen[$xp[0]] = $xp[1];
												}
												else { 
												$this->type_gen($val,$tab);
												$array_gen[] = $val; }
										}
										$v = $array_gen; //A,B,C,D
									
								break;
								case 'str':
								case 'STR':
								case 'STRING':
								case 'string':
								default:			
									$v = (string) $valx;			
							}

					}
	}
	
}
?>