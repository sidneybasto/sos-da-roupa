<?php
class pdfreport_qrcodes_grid
{
   var $Ini;
   var $Erro;
   var $Pdf;
   var $Db;
   var $rs_grid;
   var $nm_grid_sem_reg;
   var $SC_seq_register;
   var $nm_location;
   var $nm_data;
   var $nm_cod_barra;
   var $sc_proc_grid; 
   var $nmgp_botoes = array();
   var $Campos_Mens_erro;
   var $NM_raiz_img; 
   var $Font_ttf; 
   var $id = array();
   var $ticket = array();
   var $cliente = array();
   var $telefone = array();
   var $email = array();
   var $vendedor = array();
   var $qtde_cupons = array();
   var $imprimir = array();
   var $created = array();
   var $qrcode = array();
//--- 
 function monta_grid($linhas = 0)
 {

   clearstatcache();
   $this->inicializa();
   $this->grid();
 }
//--- 
 function inicializa()
 {
   global $nm_saida, 
   $rec, $nmgp_chave, $nmgp_opcao, $nmgp_ordem, $nmgp_chave_det, 
   $nmgp_quant_linhas, $nmgp_quant_colunas, $nmgp_url_saida, $nmgp_parms;
//
   $this->nm_data = new nm_data("pt_br");
   include_once("../_lib/lib/php/nm_font_tcpdf.php");
   $this->default_font = '';
   $this->default_font_sr  = '';
   $this->default_style    = '';
   $this->default_style_sr = 'B';
   $Tp_papel = array(50, 50);
   $old_dir = getcwd();
   $File_font_ttf     = "";
   $temp_font_ttf     = "";
   $this->Font_ttf    = false;
   $this->Font_ttf_sr = false;
   if (empty($this->default_font) && isset($arr_font_tcpdf[$this->Ini->str_lang]))
   {
       $this->default_font = $arr_font_tcpdf[$this->Ini->str_lang];
   }
   elseif (empty($this->default_font))
   {
       $this->default_font = "Times";
   }
   if (empty($this->default_font_sr) && isset($arr_font_tcpdf[$this->Ini->str_lang]))
   {
       $this->default_font_sr = $arr_font_tcpdf[$this->Ini->str_lang];
   }
   elseif (empty($this->default_font_sr))
   {
       $this->default_font_sr = "Times";
   }
   $_SESSION['scriptcase']['pdfreport_qrcodes']['default_font'] = $this->default_font;
   chdir($this->Ini->path_third . "/tcpdf/");
   include_once("tcpdf.php");
   chdir($old_dir);
   $this->Pdf = new TCPDF('P', 'mm', $Tp_papel, true, 'UTF-8', false);
   $this->Pdf->setPrintHeader(false);
   $this->Pdf->setPrintFooter(false);
   if (!empty($File_font_ttf))
   {
       $this->Pdf->addTTFfont($File_font_ttf, "", "", 32, $_SESSION['scriptcase']['dir_temp'] . "/");
   }
   $this->Pdf->SetDisplayMode('real');
   $this->aba_iframe = false;
   if (isset($_SESSION['scriptcase']['sc_aba_iframe']))
   {
       foreach ($_SESSION['scriptcase']['sc_aba_iframe'] as $aba => $apls_aba)
       {
           if (in_array("pdfreport_qrcodes", $apls_aba))
           {
               $this->aba_iframe = true;
               break;
           }
       }
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['iframe_menu'] && (!isset($_SESSION['scriptcase']['menu_mobile']) || empty($_SESSION['scriptcase']['menu_mobile'])))
   {
       $this->aba_iframe = true;
   }
   $this->nmgp_botoes['exit'] = "on";
   $this->sc_proc_grid = false; 
   $this->NM_raiz_img = $this->Ini->root;
   $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
   $this->nm_where_dinamico = "";
   $this->nm_grid_colunas = 0;
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['campos_busca']))
   { 
       $Busca_temp = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['campos_busca'];
       if ($_SESSION['scriptcase']['charset'] != "UTF-8")
       {
           $Busca_temp = NM_conv_charset($Busca_temp, $_SESSION['scriptcase']['charset'], "UTF-8");
       }
       $this->id[0] = $Busca_temp['id']; 
       $tmp_pos = strpos($this->id[0], "##@@");
       if ($tmp_pos !== false && !is_array($this->id[0]))
       {
           $this->id[0] = substr($this->id[0], 0, $tmp_pos);
       }
       $this->ticket[0] = $Busca_temp['ticket']; 
       $tmp_pos = strpos($this->ticket[0], "##@@");
       if ($tmp_pos !== false && !is_array($this->ticket[0]))
       {
           $this->ticket[0] = substr($this->ticket[0], 0, $tmp_pos);
       }
       $this->cliente[0] = $Busca_temp['cliente']; 
       $tmp_pos = strpos($this->cliente[0], "##@@");
       if ($tmp_pos !== false && !is_array($this->cliente[0]))
       {
           $this->cliente[0] = substr($this->cliente[0], 0, $tmp_pos);
       }
       $this->telefone[0] = $Busca_temp['telefone']; 
       $tmp_pos = strpos($this->telefone[0], "##@@");
       if ($tmp_pos !== false && !is_array($this->telefone[0]))
       {
           $this->telefone[0] = substr($this->telefone[0], 0, $tmp_pos);
       }
       $this->qrcode[0] = $Busca_temp['qrcode']; 
       $tmp_pos = strpos($this->qrcode[0], "##@@");
       if ($tmp_pos !== false && !is_array($this->qrcode[0]))
       {
           $this->qrcode[0] = substr($this->qrcode[0], 0, $tmp_pos);
       }
   } 
   $this->nm_field_dinamico = array();
   $this->nm_order_dinamico = array();
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_pesq_filtro'];
   $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
   $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
   $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
   $_SESSION['scriptcase']['contr_link_emb'] = $this->nm_location;
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['qt_col_grid'] = 1 ;  
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['pdfreport_qrcodes']['cols']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['pdfreport_qrcodes']['cols']))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['qt_col_grid'] = $_SESSION['scriptcase']['sc_apl_conf']['pdfreport_qrcodes']['cols'];  
       unset($_SESSION['scriptcase']['sc_apl_conf']['pdfreport_qrcodes']['cols']);
   }
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['ordem_select']))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['ordem_select'] = array(); 
   } 
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['ordem_quebra']))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['ordem_grid'] = "" ; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['ordem_ant']  = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['ordem_desc'] = "" ; 
   }   
   if (!empty($nmgp_parms) && $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['opcao'] != "pdf")   
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['opcao'] = "igual";
       $rec = "ini";
   }
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_orig']) || $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['prim_cons'] || !empty($nmgp_parms))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['prim_cons'] = false;  
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_orig'] = " where imprimir='S'";  
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_pesq']        = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_orig'];  
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_pesq_ant']    = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_orig'];  
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['cond_pesq']         = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_pesq_filtro'] = "";
   }   
   if  (!empty($this->nm_where_dinamico)) 
   {   
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_pesq'] .= $this->nm_where_dinamico;
   }   
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_pesq_filtro'];
//
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['tot_geral'][1])) 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['sc_total'] = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['tot_geral'][1] ;  
   }
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_pesq_ant'] = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_pesq'];  
//----- 
   if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
   { 
       $nmgp_select = "SELECT id, ticket, cliente, telefone, email, vendedor, qtde_cupons, imprimir, created, qrcode from " . $this->Ini->nm_tabela; 
   } 
   else 
   { 
       $nmgp_select = "SELECT id, ticket, cliente, telefone, email, vendedor, qtde_cupons, imprimir, created, qrcode from " . $this->Ini->nm_tabela; 
   } 
   $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_pesq']; 
   $nmgp_order_by = ""; 
   $campos_order_select = "";
   foreach($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['ordem_select'] as $campo => $ordem) 
   {
        if ($campo != $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['ordem_grid']) 
        {
           if (!empty($campos_order_select)) 
           {
               $campos_order_select .= ", ";
           }
           $campos_order_select .= $campo . " " . $ordem;
        }
   }
   if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['ordem_grid'])) 
   { 
       $nmgp_order_by = " order by " . $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['ordem_grid'] . $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['ordem_desc']; 
   } 
   if (!empty($campos_order_select)) 
   { 
       if (!empty($nmgp_order_by)) 
       { 
          $nmgp_order_by .= ", " . $campos_order_select; 
       } 
       else 
       { 
          $nmgp_order_by = " order by $campos_order_select"; 
       } 
   } 
   $nmgp_select .= $nmgp_order_by; 
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['order_grid'] = $nmgp_order_by;
   $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select; 
   $this->rs_grid = $this->Db->Execute($nmgp_select) ; 
   if ($this->rs_grid === false && !$this->rs_grid->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1) 
   { 
       $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
       exit ; 
   }  
   if ($this->rs_grid->EOF || ($this->rs_grid === false && $GLOBALS["NM_ERRO_IBASE"] == 1)) 
   { 
       $this->nm_grid_sem_reg = $this->Ini->Nm_lang['lang_errm_empt']; 
   }  
// 
 }  
// 
 function Pdf_init()
 {
     if ($_SESSION['scriptcase']['reg_conf']['css_dir'] == "RTL")
     {
         $this->Pdf->setRTL(true);
     }
     $this->Pdf->setHeaderMargin(0);
     $this->Pdf->setFooterMargin(0);
     if ($this->Font_ttf)
     {
         $this->Pdf->SetFont($this->default_font, $this->default_style, 12, $this->def_TTF);
     }
     else
     {
         $this->Pdf->SetFont($this->default_font, $this->default_style, 12);
     }
     $this->Pdf->SetTextColor(0, 0, 0);
 }
// 
//----- 
 function grid($linhas = 0)
 {
    global 
           $nm_saida, $nm_url_saida;
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['labels']['id'] = "Id";
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['labels']['ticket'] = "Ticket";
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['labels']['cliente'] = "Cliente";
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['labels']['telefone'] = "Telefone";
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['labels']['email'] = "Email";
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['labels']['vendedor'] = "Vendedor";
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['labels']['qtde_cupons'] = "Qtde Cupons";
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['labels']['imprimir'] = "Imprimir";
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['labels']['created'] = "Created";
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['labels']['qrcode'] = "qrcode";
   $HTTP_REFERER = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : ""; 
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['seq_dir'] = 0; 
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['sub_dir'] = array(); 
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['where_pesq_filtro'];
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['pdfreport_qrcodes']['lig_edit']) && $_SESSION['scriptcase']['sc_apl_conf']['pdfreport_qrcodes']['lig_edit'] != '')
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['mostra_edit'] = $_SESSION['scriptcase']['sc_apl_conf']['pdfreport_qrcodes']['lig_edit'];
   }
   if (!empty($this->nm_grid_sem_reg))
   {
       $this->Pdf_init();
       $this->Pdf->AddPage();
       if ($this->Font_ttf_sr)
       {
           $this->Pdf->SetFont($this->default_font_sr, 'B', 12, $this->def_TTF);
       }
       else
       {
           $this->Pdf->SetFont($this->default_font_sr, 'B', 12);
       }
       $this->Pdf->SetTextColor(0, 0, 0);
       $this->Pdf->Text(0,000000, 0,000000, html_entity_decode($this->nm_grid_sem_reg, ENT_COMPAT, $_SESSION['scriptcase']['charset']));
       $this->Pdf->Output($this->Ini->root . $this->Ini->nm_path_pdf, 'F');
       return;
   }
// 
   $Init_Pdf = true;
   $this->SC_seq_register = 0; 
   while (!$this->rs_grid->EOF) 
   {  
      $this->nm_grid_colunas = 0; 
      $nm_quant_linhas = 0;
      $this->Pdf->setImageScale(1.33);
      $this->Pdf->AddPage();
      $this->Pdf_init();
      while (!$this->rs_grid->EOF && $nm_quant_linhas < $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_qrcodes']['qt_col_grid']) 
      {  
          $this->sc_proc_grid = true;
          $this->SC_seq_register++; 
          $this->id[$this->nm_grid_colunas] = $this->rs_grid->fields[0] ;  
          $this->id[$this->nm_grid_colunas] = (string)$this->id[$this->nm_grid_colunas];
          $this->ticket[$this->nm_grid_colunas] = $this->rs_grid->fields[1] ;  
          $this->ticket[$this->nm_grid_colunas] = (string)$this->ticket[$this->nm_grid_colunas];
          $this->cliente[$this->nm_grid_colunas] = $this->rs_grid->fields[2] ;  
          $this->telefone[$this->nm_grid_colunas] = $this->rs_grid->fields[3] ;  
          $this->email[$this->nm_grid_colunas] = $this->rs_grid->fields[4] ;  
          $this->vendedor[$this->nm_grid_colunas] = $this->rs_grid->fields[5] ;  
          $this->vendedor[$this->nm_grid_colunas] = (string)$this->vendedor[$this->nm_grid_colunas];
          $this->qtde_cupons[$this->nm_grid_colunas] = $this->rs_grid->fields[6] ;  
          $this->qtde_cupons[$this->nm_grid_colunas] = (string)$this->qtde_cupons[$this->nm_grid_colunas];
          $this->imprimir[$this->nm_grid_colunas] = $this->rs_grid->fields[7] ;  
          $this->created[$this->nm_grid_colunas] = $this->rs_grid->fields[8] ;  
          $this->qrcode[$this->nm_grid_colunas] = $this->rs_grid->fields[9] ;  
          $_SESSION['scriptcase']['pdfreport_qrcodes']['contr_erro'] = 'on';
 

     $nm_select = "UPDATE qrcodes SET imprimir='N'"; 
         $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
         $rf = $this->Db->Execute($nm_select);
         if ($rf === false)
         {
             $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
             if ($this->Ini->sc_tem_trans_banco)
             {
                 $this->Db->RollbackTrans(); 
                 $this->Ini->sc_tem_trans_banco = false;
             }
             exit;
         }
         $rf->Close();
      ;
$_SESSION['scriptcase']['pdfreport_qrcodes']['contr_erro'] = 'off';
          $this->id[$this->nm_grid_colunas] = sc_strip_script($this->id[$this->nm_grid_colunas]);
          if ($this->id[$this->nm_grid_colunas] === "") 
          { 
              $this->id[$this->nm_grid_colunas] = "" ;  
          } 
          else    
          { 
              nmgp_Form_Num_Val($this->id[$this->nm_grid_colunas], $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
          } 
          $this->id[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->id[$this->nm_grid_colunas]);
          $this->ticket[$this->nm_grid_colunas] = sc_strip_script($this->ticket[$this->nm_grid_colunas]);
          if ($this->ticket[$this->nm_grid_colunas] === "") 
          { 
              $this->ticket[$this->nm_grid_colunas] = "" ;  
          } 
          $this->ticket[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->ticket[$this->nm_grid_colunas]);
          $this->cliente[$this->nm_grid_colunas] = sc_strip_script($this->cliente[$this->nm_grid_colunas]);
          if ($this->cliente[$this->nm_grid_colunas] === "") 
          { 
              $this->cliente[$this->nm_grid_colunas] = "" ;  
          } 
          $this->cliente[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->cliente[$this->nm_grid_colunas]);
          $this->telefone[$this->nm_grid_colunas] = sc_strip_script($this->telefone[$this->nm_grid_colunas]);
          if ($this->telefone[$this->nm_grid_colunas] === "") 
          { 
              $this->telefone[$this->nm_grid_colunas] = "" ;  
          } 
          $this->telefone[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->telefone[$this->nm_grid_colunas]);
          $this->email[$this->nm_grid_colunas] = sc_strip_script($this->email[$this->nm_grid_colunas]);
          if ($this->email[$this->nm_grid_colunas] === "") 
          { 
              $this->email[$this->nm_grid_colunas] = "" ;  
          } 
          $this->email[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->email[$this->nm_grid_colunas]);
          $this->vendedor[$this->nm_grid_colunas] = sc_strip_script($this->vendedor[$this->nm_grid_colunas]);
          if ($this->vendedor[$this->nm_grid_colunas] === "") 
          { 
              $this->vendedor[$this->nm_grid_colunas] = "" ;  
          } 
          else    
          { 
              nmgp_Form_Num_Val($this->vendedor[$this->nm_grid_colunas], $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
          } 
          $this->vendedor[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->vendedor[$this->nm_grid_colunas]);
          $this->qtde_cupons[$this->nm_grid_colunas] = sc_strip_script($this->qtde_cupons[$this->nm_grid_colunas]);
          if ($this->qtde_cupons[$this->nm_grid_colunas] === "") 
          { 
              $this->qtde_cupons[$this->nm_grid_colunas] = "" ;  
          } 
          else    
          { 
              nmgp_Form_Num_Val($this->qtde_cupons[$this->nm_grid_colunas], $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "5", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'], $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
          } 
          $this->qtde_cupons[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->qtde_cupons[$this->nm_grid_colunas]);
          $this->imprimir[$this->nm_grid_colunas] = sc_strip_script($this->imprimir[$this->nm_grid_colunas]);
          if ($this->imprimir[$this->nm_grid_colunas] === "") 
          { 
              $this->imprimir[$this->nm_grid_colunas] = "" ;  
          } 
          $this->imprimir[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->imprimir[$this->nm_grid_colunas]);
          $this->created[$this->nm_grid_colunas] = sc_strip_script($this->created[$this->nm_grid_colunas]);
          if ($this->created[$this->nm_grid_colunas] === "") 
          { 
              $this->created[$this->nm_grid_colunas] = "" ;  
          } 
          else    
          { 
               if (substr($this->created[$this->nm_grid_colunas], 10, 1) == "-") 
               { 
                  $this->created[$this->nm_grid_colunas] = substr($this->created[$this->nm_grid_colunas], 0, 10) . " " . substr($this->created[$this->nm_grid_colunas], 11);
               } 
               if (substr($this->created[$this->nm_grid_colunas], 13, 1) == ".") 
               { 
                  $this->created[$this->nm_grid_colunas] = substr($this->created[$this->nm_grid_colunas], 0, 13) . ":" . substr($this->created[$this->nm_grid_colunas], 14, 2) . ":" . substr($this->created[$this->nm_grid_colunas], 17);
               } 
               $created_x =  $this->created[$this->nm_grid_colunas];
               nm_conv_limpa_dado($created_x, "YYYY-MM-DD HH:II:SS");
               if (is_numeric($created_x) && $created_x > 0) 
               { 
                   $this->nm_data->SetaData($this->created[$this->nm_grid_colunas], "YYYY-MM-DD HH:II:SS");
                   $this->created[$this->nm_grid_colunas] = html_entity_decode($this->nm_data->FormataSaida($this->nm_data->FormatRegion("DH", "ddmmaaaa;hhiiss")), ENT_COMPAT, $_SESSION['scriptcase']['charset']);
               } 
          } 
          $this->created[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->created[$this->nm_grid_colunas]);
          $this->qrcode[$this->nm_grid_colunas] = $this->qrcode[$this->nm_grid_colunas]; 
          if (empty($this->qrcode[$this->nm_grid_colunas]) || $this->qrcode[$this->nm_grid_colunas] == "none" || $this->qrcode[$this->nm_grid_colunas] == "*nm*") 
          { 
              $this->qrcode[$this->nm_grid_colunas] = "" ;  
              $out_qrcode = "" ; 
          } 
          elseif ($this->Ini->Gd_missing)
          { 
              $this->qrcode[$this->nm_grid_colunas] = "<span class=\"scErrorLine\">" . $this->Ini->Nm_lang['lang_errm_gd'] . "</span>";
              $out_qrcode = "" ; 
          } 
          else   
          { 
              $out_qrcode = $this->Ini->path_imag_temp . "/sc_qrcode_" . $_SESSION['scriptcase']['sc_num_img'] . session_id() . ".png";   
              QRcode::png($this->qrcode[$this->nm_grid_colunas], $this->Ini->root . $out_qrcode, 0,2,1);
              $_SESSION['scriptcase']['sc_num_img']++;
          } 
              $this->qrcode[$this->nm_grid_colunas] = $this->NM_raiz_img . $out_qrcode;
          $this->qrcode[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->qrcode[$this->nm_grid_colunas]);
            $cell_ticket = array('posx' => '9.731718958332106', 'posy' => '5.70920562499928', 'data' => $this->ticket[$this->nm_grid_colunas], 'width'      => '0', 'align'      => 'L', 'font_type'  => $this->default_font, 'font_size'  => '8', 'color_r'    => '0', 'color_g'    => '0', 'color_b'    => '0', 'font_style' => $this->default_style);
            $cell_qrcode = array('posx' => '7.879635624999007', 'posy' => '10.566796874998667', 'data' => $this->qrcode[$this->nm_grid_colunas], 'width'      => '0', 'align'      => 'L', 'font_type'  => $this->default_font, 'font_size'  => '12', 'color_r'    => '0', 'color_g'    => '0', 'color_b'    => '0', 'font_style' => $this->default_style);


            $this->Pdf->SetFont($cell_ticket['font_type'], $cell_ticket['font_style'], $cell_ticket['font_size']);
            $this->pdf_text_color($cell_ticket['data'], $cell_ticket['color_r'], $cell_ticket['color_g'], $cell_ticket['color_b']);
            if (!empty($cell_ticket['posx']) && !empty($cell_ticket['posy']))
            {
                $this->Pdf->SetXY($cell_ticket['posx'], $cell_ticket['posy']);
            }
            elseif (!empty($cell_ticket['posx']))
            {
                $this->Pdf->SetX($cell_ticket['posx']);
            }
            elseif (!empty($cell_ticket['posy']))
            {
                $this->Pdf->SetY($cell_ticket['posy']);
            }
            $this->Pdf->Cell($cell_ticket['width'], 0, $cell_ticket['data'], 0, 0, $cell_ticket['align']);

            if (isset($cell_qrcode['data']) && !empty($cell_qrcode['data']) && is_file($cell_qrcode['data']))
            {
                $Finfo_img = finfo_open(FILEINFO_MIME_TYPE);
                $Tipo_img  = finfo_file($Finfo_img, $cell_qrcode['data']);
                finfo_close($Finfo_img);
                if (substr($Tipo_img, 0, 5) == "image")
                {
                    $this->Pdf->Image($cell_qrcode['data'], $cell_qrcode['posx'], $cell_qrcode['posy'], 0, 0);
                }
            }
// pagina 3-51

print chr(27) . chr(100) . chr(48);
      
//echo chr(27) . chr(100) . chr(48);



//print chr(12);  // form feed

//$a="ESC";
//$b="d";
//$c=48;
//printf("%c",$a,$b,$c); 


          $max_Y = 0;
          $this->rs_grid->MoveNext();
          $this->sc_proc_grid = false;
          $nm_quant_linhas++ ;
      }  
   }  
   $this->rs_grid->Close();
   $this->Pdf->Output($this->Ini->root . $this->Ini->nm_path_pdf, 'F');
 }
 function pdf_text_color(&$val, $r, $g, $b)
 {
     $pos = strpos($val, "@SCNEG#");
     if ($pos !== false)
     {
         $cor = trim(substr($val, $pos + 7));
         $val = substr($val, 0, $pos);
         $cor = (substr($cor, 0, 1) == "#") ? substr($cor, 1) : $cor;
         if (strlen($cor) == 6)
         {
             $r = hexdec(substr($cor, 0, 2));
             $g = hexdec(substr($cor, 2, 2));
             $b = hexdec(substr($cor, 4, 2));
         }
     }
     $this->Pdf->SetTextColor($r, $g, $b);
 }
 function SC_conv_utf8($input)
 {
     if ($_SESSION['scriptcase']['charset'] != "UTF-8" && !NM_is_utf8($input))
     {
         $input = sc_convert_encoding($input, "UTF-8", $_SESSION['scriptcase']['charset']);
     }
     return $input;
 }
   function nm_conv_data_db($dt_in, $form_in, $form_out)
   {
       $dt_out = $dt_in;
       if (strtoupper($form_in) == "DB_FORMAT")
       {
           if ($dt_out == "null" || $dt_out == "")
           {
               $dt_out = "";
               return $dt_out;
           }
           $form_in = "AAAA-MM-DD";
       }
       if (strtoupper($form_out) == "DB_FORMAT")
       {
           if (empty($dt_out))
           {
               $dt_out = "null";
               return $dt_out;
           }
           $form_out = "AAAA-MM-DD";
       }
       nm_conv_form_data($dt_out, $form_in, $form_out);
       return $dt_out;
   }
   function nm_gera_mask(&$nm_campo, $nm_mask)
   { 
      $trab_campo = $nm_campo;
      $trab_mask  = $nm_mask;
      $tam_campo  = strlen($nm_campo);
      $trab_saida = "";
      $mask_num = false;
      for ($x=0; $x < strlen($trab_mask); $x++)
      {
          if (substr($trab_mask, $x, 1) == "#")
          {
              $mask_num = true;
              break;
          }
      }
      if ($mask_num )
      {
          $ver_duas = explode(";", $trab_mask);
          if (isset($ver_duas[1]) && !empty($ver_duas[1]))
          {
              $cont1 = count(explode("#", $ver_duas[0])) - 1;
              $cont2 = count(explode("#", $ver_duas[1])) - 1;
              if ($cont2 >= $tam_campo)
              {
                  $trab_mask = $ver_duas[1];
              }
              else
              {
                  $trab_mask = $ver_duas[0];
              }
          }
          $tam_mask = strlen($trab_mask);
          $xdados = 0;
          for ($x=0; $x < $tam_mask; $x++)
          {
              if (substr($trab_mask, $x, 1) == "#" && $xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_campo, $xdados, 1);
                  $xdados++;
              }
              elseif ($xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_mask, $x, 1);
              }
          }
          if ($xdados < $tam_campo)
          {
              $trab_saida .= substr($trab_campo, $xdados);
          }
          $nm_campo = $trab_saida;
          return;
      }
      for ($ix = strlen($trab_mask); $ix > 0; $ix--)
      {
           $char_mask = substr($trab_mask, $ix - 1, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               $trab_saida = $char_mask . $trab_saida;
           }
           else
           {
               if ($tam_campo != 0)
               {
                   $trab_saida = substr($trab_campo, $tam_campo - 1, 1) . $trab_saida;
                   $tam_campo--;
               }
               else
               {
                   $trab_saida = "0" . $trab_saida;
               }
           }
      }
      if ($tam_campo != 0)
      {
          $trab_saida = substr($trab_campo, 0, $tam_campo) . $trab_saida;
          $trab_mask  = str_repeat("z", $tam_campo) . $trab_mask;
      }
   
      $iz = 0; 
      for ($ix = 0; $ix < strlen($trab_mask); $ix++)
      {
           $char_mask = substr($trab_mask, $ix, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               if ($char_mask == "." || $char_mask == ",")
               {
                   $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
               }
               else
               {
                   $iz++;
               }
           }
           elseif ($char_mask == "x" || substr($trab_saida, $iz, 1) != "0")
           {
               $ix = strlen($trab_mask) + 1;
           }
           else
           {
               $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
           }
      }
      $nm_campo = $trab_saida;
   } 
}
?>
