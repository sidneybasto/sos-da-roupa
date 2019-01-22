
function scJQGeneralAdd() {
  scLoadScInput('input:text.sc-js-input');
  scLoadScInput('input:password.sc-js-input');
  scLoadScInput('input:checkbox.sc-js-input');
  scLoadScInput('input:radio.sc-js-input');
  scLoadScInput('select.sc-js-input');
  scLoadScInput('textarea.sc-js-input');

} // scJQGeneralAdd

function scFocusField(sField) {
  var $oField = $('#id_sc_field_' + sField);

  if (0 == $oField.length) {
    $oField = $('input[name=' + sField + ']');
  }

  if (0 == $oField.length && document.F1.elements[sField]) {
    $oField = $(document.F1.elements[sField]);
  }

  if (false == scSetFocusOnField($oField) && $("#id_ac_" + sField).length > 0) {
    if (false == scSetFocusOnField($("#id_ac_" + sField))) {
      setTimeout(function() { scSetFocusOnField($("#id_ac_" + sField)); }, 500);
    }
  }
  else {
    setTimeout(function() { scSetFocusOnField($oField); }, 500);
  }
} // scFocusField

function scSetFocusOnField($oField) {
  if ($oField.length > 0 && $oField[0].offsetHeight > 0 && $oField[0].offsetWidth > 0 && !$oField[0].disabled) {
    $oField[0].focus();
    return true;
  }
  return false;
} // scSetFocusOnField

function scEventControl_init(iSeqRow) {
  scEventControl_data["id_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["ticket_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["cliente_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["vendedor_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["imprimir_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
}

function scEventControl_active(iSeqRow) {
  if (scEventControl_data["id_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["id_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["ticket_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["ticket_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["cliente_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["cliente_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["vendedor_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["vendedor_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["imprimir_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["imprimir_" + iSeqRow]["change"]) {
    return true;
  }
  return false;
} // scEventControl_active

function scEventControl_active_all() {
  for (var i = 1; i < iAjaxNewLine; i++) {
    if (scEventControl_active(i)) {
      return true;
    }
  }
  return false;
} // scEventControl_active

function scEventControl_onFocus(oField, iSeq) {
  var fieldId, fieldName;
  fieldId = $(oField).attr("id");
  fieldName = fieldId.substr(12);
  scEventControl_data[fieldName]["blur"] = true;
  scEventControl_data[fieldName]["change"] = false;
} // scEventControl_onFocus

function scEventControl_onBlur(sFieldName) {
  scEventControl_data[sFieldName]["blur"] = false;
  if (scEventControl_data[sFieldName]["change"]) {
        if (scEventControl_data[sFieldName]["original"] == $("#id_sc_field_" + sFieldName).val() || scEventControl_data[sFieldName]["calculated"] == $("#id_sc_field_" + sFieldName).val()) {
          scEventControl_data[sFieldName]["change"] = false;
        }
  }
} // scEventControl_onBlur

function scEventControl_onChange(sFieldName) {
  scEventControl_data[sFieldName]["change"] = false;
} // scEventControl_onChange

function scEventControl_onAutocomp(sFieldName) {
  scEventControl_data[sFieldName]["autocomp"] = false;
} // scEventControl_onChange

var scEventControl_data = {};

function scJQEventsAdd(iSeqRow) {
  $('#id_sc_field_id_' + iSeqRow).bind('blur', function() { sc_reimpressao_form_qrcodes_id__onblur(this, iSeqRow) })
                                 .bind('change', function() { sc_reimpressao_form_qrcodes_id__onchange(this, iSeqRow) })
                                 .bind('focus', function() { sc_reimpressao_form_qrcodes_id__onfocus(this, iSeqRow) });
  $('#id_sc_field_ticket_' + iSeqRow).bind('blur', function() { sc_reimpressao_form_qrcodes_ticket__onblur(this, iSeqRow) })
                                     .bind('change', function() { sc_reimpressao_form_qrcodes_ticket__onchange(this, iSeqRow) })
                                     .bind('focus', function() { sc_reimpressao_form_qrcodes_ticket__onfocus(this, iSeqRow) });
  $('#id_sc_field_cliente_' + iSeqRow).bind('blur', function() { sc_reimpressao_form_qrcodes_cliente__onblur(this, iSeqRow) })
                                      .bind('change', function() { sc_reimpressao_form_qrcodes_cliente__onchange(this, iSeqRow) })
                                      .bind('focus', function() { sc_reimpressao_form_qrcodes_cliente__onfocus(this, iSeqRow) });
  $('#id_sc_field_vendedor_' + iSeqRow).bind('blur', function() { sc_reimpressao_form_qrcodes_vendedor__onblur(this, iSeqRow) })
                                       .bind('change', function() { sc_reimpressao_form_qrcodes_vendedor__onchange(this, iSeqRow) })
                                       .bind('focus', function() { sc_reimpressao_form_qrcodes_vendedor__onfocus(this, iSeqRow) });
  $('#id_sc_field_imprimir_' + iSeqRow).bind('blur', function() { sc_reimpressao_form_qrcodes_imprimir__onblur(this, iSeqRow) })
                                       .bind('change', function() { sc_reimpressao_form_qrcodes_imprimir__onchange(this, iSeqRow) })
                                       .bind('focus', function() { sc_reimpressao_form_qrcodes_imprimir__onfocus(this, iSeqRow) });
} // scJQEventsAdd

function sc_reimpressao_form_qrcodes_id__onblur(oThis, iSeqRow) {
  do_ajax_reimpressao_form_qrcodes_validate_id_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_reimpressao_form_qrcodes_id__onchange(oThis, iSeqRow) {
  nm_check_insert(iSeqRow);
}

function sc_reimpressao_form_qrcodes_id__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_reimpressao_form_qrcodes_ticket__onblur(oThis, iSeqRow) {
  do_ajax_reimpressao_form_qrcodes_validate_ticket_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_reimpressao_form_qrcodes_ticket__onchange(oThis, iSeqRow) {
  nm_check_insert(iSeqRow);
}

function sc_reimpressao_form_qrcodes_ticket__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_reimpressao_form_qrcodes_cliente__onblur(oThis, iSeqRow) {
  do_ajax_reimpressao_form_qrcodes_validate_cliente_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_reimpressao_form_qrcodes_cliente__onchange(oThis, iSeqRow) {
  nm_check_insert(iSeqRow);
}

function sc_reimpressao_form_qrcodes_cliente__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_reimpressao_form_qrcodes_vendedor__onblur(oThis, iSeqRow) {
  do_ajax_reimpressao_form_qrcodes_validate_vendedor_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_reimpressao_form_qrcodes_vendedor__onchange(oThis, iSeqRow) {
  nm_check_insert(iSeqRow);
}

function sc_reimpressao_form_qrcodes_vendedor__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_reimpressao_form_qrcodes_imprimir__onblur(oThis, iSeqRow) {
  do_ajax_reimpressao_form_qrcodes_validate_imprimir_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_reimpressao_form_qrcodes_imprimir__onchange(oThis, iSeqRow) {
  nm_check_insert(iSeqRow);
}

function sc_reimpressao_form_qrcodes_imprimir__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function displayChange_block(block, status) {
	if ("0" == block) {
		displayChange_block_0(status);
	}
}

function displayChange_block_0(status) {
	displayChange_field("id_", "", status);
	displayChange_field("ticket_", "", status);
	displayChange_field("cliente_", "", status);
	displayChange_field("vendedor_", "", status);
	displayChange_field("imprimir_", "", status);
}

function displayChange_row(row, status) {
	displayChange_field_id_(row, status);
	displayChange_field_ticket_(row, status);
	displayChange_field_cliente_(row, status);
	displayChange_field_vendedor_(row, status);
	displayChange_field_imprimir_(row, status);
}

function displayChange_field(field, row, status) {
	if ("id_" == field) {
		displayChange_field_id_(row, status);
	}
	if ("ticket_" == field) {
		displayChange_field_ticket_(row, status);
	}
	if ("cliente_" == field) {
		displayChange_field_cliente_(row, status);
	}
	if ("vendedor_" == field) {
		displayChange_field_vendedor_(row, status);
	}
	if ("imprimir_" == field) {
		displayChange_field_imprimir_(row, status);
	}
}

function displayChange_field_id_(row, status) {
}

function displayChange_field_ticket_(row, status) {
}

function displayChange_field_cliente_(row, status) {
}

function displayChange_field_vendedor_(row, status) {
}

function displayChange_field_imprimir_(row, status) {
}

function scResetPagesDisplay() {
	$(".sc-form-page").show();
}

function scHidePage(pageNo) {
	$("#id_reimpressao_form_qrcodes_form" + pageNo).hide();
}

function scCheckNoPageSelected() {
	if (!$(".sc-form-page").filter(".scTabActive").filter(":visible").length) {
		var inactiveTabs = $(".sc-form-page").filter(".scTabInactive").filter(":visible");
		if (inactiveTabs.length) {
			var tabNo = $(inactiveTabs[0]).attr("id").substr(32);
		}
	}
}
var sc_jq_calendar_value = {};

function scJQCalendarAdd(iSeqRow) {
  $("#id_sc_field_created_" + iSeqRow).datepicker({
    beforeShow: function(input, inst) {
      var $oField = $(this),
          aParts  = $oField.val().split(" "),
          sTime   = "";
      sc_jq_calendar_value["#id_sc_field_created_" + iSeqRow] = $oField.val();
      if (2 == aParts.length) {
        sTime = " " + aParts[1];
      }
      if ('' == sTime || ' ' == sTime) {
        sTime = ' <?php echo $this->jqueryCalendarTimeStart($this->field_config['created_']['date_format']); ?>';
      }
      $oField.datepicker("option", "dateFormat", "<?php echo $this->jqueryCalendarDtFormat("" . str_replace(array('/', 'aaaa', 'hh', 'ii', 'ss', ':', ';', $_SESSION['scriptcase']['reg_conf']['date_sep'], $_SESSION['scriptcase']['reg_conf']['time_sep']), array('', 'yyyy', '','','', '', '', '', ''), $this->field_config['created_']['date_format']) . "", "" . $_SESSION['scriptcase']['reg_conf']['date_sep'] . ""); ?>" + sTime);
    },
    onClose: function(dateText, inst) {
      do_ajax_reimpressao_form_qrcodes_validate_created_(iSeqRow);
    },
    showWeek: true,
    numberOfMonths: 1,
    changeMonth: true,
    changeYear: true,
    yearRange: 'c-5:c+5',
    dayNames: ["<?php        echo html_entity_decode($this->Ini->Nm_lang['lang_days_sund'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);        ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_days_mond'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);        ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_days_tued'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);        ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_days_wend'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);        ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_days_thud'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);        ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_days_frid'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);        ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_days_satd'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);        ?>"],
    dayNamesMin: ["<?php     echo html_entity_decode($this->Ini->Nm_lang['lang_substr_days_sund'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_substr_days_mond'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_substr_days_tued'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_substr_days_wend'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_substr_days_thud'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_substr_days_frid'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_substr_days_satd'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>"],
    monthNames: ["<?php      echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_janu"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_febr"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_marc"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_apri"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_mayy"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_june"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_july"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_augu"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_sept"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_octo"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_nove"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>","<?php echo html_entity_decode($this->Ini->Nm_lang["lang_mnth_dece"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);      ?>"],
    monthNamesShort: ["<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_janu'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);   ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_febr'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);   ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_marc'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);   ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_apri'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);   ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_mayy'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);   ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_june'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);   ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_july'], ENT_COMPAT, $_SESSION['scriptcase']['charset']);   ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_augu'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_sept'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_octo'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_nove'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>","<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_mnth_dece'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>"],
    weekHeader: "<?php echo html_entity_decode($this->Ini->Nm_lang['lang_shrt_days_sem'], ENT_COMPAT, $_SESSION['scriptcase']['charset']); ?>",
    firstDay: <?php echo $this->jqueryCalendarWeekInit("" . $_SESSION['scriptcase']['reg_conf']['date_week_ini'] . ""); ?>,
    dateFormat: "<?php echo $this->jqueryCalendarDtFormat("" . str_replace(array('/', 'aaaa', 'hh', 'ii', 'ss', ':', ';', $_SESSION['scriptcase']['reg_conf']['date_sep'], $_SESSION['scriptcase']['reg_conf']['time_sep']), array('', 'yyyy', '','','', '', '', '', ''), $this->field_config['created_']['date_format']) . "", "" . $_SESSION['scriptcase']['reg_conf']['date_sep'] . ""); ?>",
    showOtherMonths: true,
    showOn: "button",
    buttonImage: "<?php echo $this->jqueryIconFile('calendar'); ?>",
    buttonImageOnly: true,
    currentText: "<?php  echo html_entity_decode($this->Ini->Nm_lang["lang_per_today"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);       ?>",
    closeText: "<?php  echo html_entity_decode($this->Ini->Nm_lang["lang_btns_mess_clse"], ENT_COMPAT, $_SESSION["scriptcase"]["charset"]);       ?>",
  });

} // scJQCalendarAdd

function scJQUploadAdd(iSeqRow) {
} // scJQUploadAdd

function scJQSelect2Add(seqRow, specificField) {
} // scJQSelect2Add


function scJQElementsAdd(iLine) {
  scJQEventsAdd(iLine);
  scEventControl_init(iLine);
  scJQCalendarAdd(iLine);
  scJQUploadAdd(iLine);
  scJQSelect2Add(iLine);
} // scJQElementsAdd

