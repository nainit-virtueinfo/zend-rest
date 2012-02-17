function checkUncheckAll(frm,checkname,allcheckbox)
{// JavaScript Document
   if(typeof checkname == "undefined")
   {
		  var checkname='deleteIds[]';
   }
	
	 if(typeof allcheckbox =="undefined")
	 {
		var allcheckbox="deleteId"; 
	 }
    for ( x=0; x<frm.elements.length; x++ )
	{
		var e = frm.elements[x];
		//if ( e.name == checkname) e.checked = 'frm.'+allcheckbox+'.checked';
		
		if ( e.name == checkname) e.checked = document.getElementById(allcheckbox).checked;
	}
}

function checkUncheckOne(frm,checkname,allcheckbox)
{
	var countElement = 0;
	var selectedElement = 0;
	
	if(typeof checkname == "undefined")
   {
		  var checkname='deleteIds[]';
   }
	
	 if(typeof allcheckbox =="undefined")
	 {
		var allcheckbox="deleteId"; 
	 }
	
	for ( x=0; x<frm.elements.length; x++ )
	{
		var e = frm.elements[x];
		if ( e.name == checkname )
		{
			countElement++;
			if ( e.checked ) selectedElement++;
		}
	}
	document.getElementById(allcheckbox).checked = countElement == selectedElement;
}


function deleteAll(frm, _ttl, _id, _msgconfirm, _msgselect)
{
	if ( frm.deleteyn != undefined ) frm.deleteyn.value = 'y';
	if ( _id == undefined ) _id = '';
	var selectedElement = 0;
	for ( x=0; x<frm.elements.length; x++ )
	{
		var e = frm.elements[x];
		
		if ( e.name == 'deleteIds'+_id+'[]' && e.checked ) 
			selectedElement++;
	}
	
	if ( selectedElement == 0 )
	{
		alert(_msgselect);
		return false;
	}
	else
	{
		if ( confirm(_msgconfirm) )
			 return true;
	}

}
function ApproveAll(frm, _ttl, _id, _msgconfirm, _msgselect)
{
	if ( frm.deleteyn != undefined ) frm.deleteyn.value = 'y';
	if ( _id == undefined ) _id = '';
	var selectedElement = 0;
	for ( x=0; x<frm.elements.length; x++ )
	{
		var e = frm.elements[x];
		
		if ( e.name == 'deleteIds'+_id+'[]' && e.checked ) 
			selectedElement++;
	}
	
	if ( selectedElement == 0 )
	{
		alert(_msgselect);
		return false;
	}
	else
	{
		if ( confirm(_msgconfirm) )
			 return true;
	}


}
function showcontent(id,total,focusfield)
{	
	
	for( x=1;x <= total;x++)
	{
		if(document.getElementById('content'+x))
			document.getElementById('content'+x).style.display = 'none';
		if(document.getElementById('div'+x))	
		document.getElementById('div'+x).className = 'menu';
	}
	if(document.getElementById('content'+id))
		document.getElementById('content'+id).style.display = '';
	if(document.getElementById('div'+id))	
	document.getElementById('div'+id).className = 'menuselected';
	
}


 
