<?php

/*
 * Functions used for object batch import scripts.
*/

	# ------------------------------------------------------
	function getCollectionIDsByIdno($ps_name) {
		// $o_db = $this->getDb();
		$o_db = new Db(null, null, false);
		$qr_res = $o_db->query("
			SELECT DISTINCT cae.collection_id
			FROM ca_collections cae
			WHERE
				cae.idno = ?
		", $ps_name);
		
		$va_collection_ids = array();
		while($qr_res->nextRow()) {
			$va_collection_ids[] = $qr_res->get('collection_id');
		}
		$va_collection_id = $va_collection_ids[0] ;
		
		if (!$va_collection_id)
			return FALSE ;
		else
			return $va_collection_id;
	}
	# ------------------------------------------------------

	function getPlaceIDsByIdno($ps_name) {
		// $o_db = $this->getDb();
		$o_db = new Db(null, null, false);
		$qr_res = $o_db->query("
			SELECT DISTINCT cae.place_id
			FROM ca_places cae
			WHERE
				cae.idno = ?
		", $ps_name);
		
		$va_place_ids = array();
		while($qr_res->nextRow()) {
			$va_place_ids[] = $qr_res->get('place_id');
		}
		$va_place_id = $va_place_ids[0] ;
		
		if (!$va_place_id)
			return FALSE ;
		else
			return $va_place_id;
	}

# ------------------------------------------------------
	function objectIdnoExists($ps_name) {
		
		$o_db = new Db(null, null, false);
		$qr_res = $o_db->query("
			SELECT DISTINCT count(*) as c
			FROM ca_objects
			WHERE
				idno = ?
		", $ps_name);
		
		$va_object_counts = array();
		while($qr_res->nextRow()) {
			$va_object_counts[] = $qr_res->get('c');
		}
		$vi_object_count = $va_object_counts[0] ;
		
		if ($vi_object_count == 0)
			return FALSE ;
		else
			return TRUE ;
	}


	# ------------------------------------------------------
	function getPreferredLabelForLocale($idno, $localeid) {
		
		$o_db = new Db(null, null, false);
		
		if (ereg("COLLECTION.JMP.", $idno))
			{
			$qr_res = $o_db->query("
				SELECT DISTINCT cal.name
				FROM ca_collections cae, ca_collection_labels cal
				WHERE
					cae.idno = ?
					and cae.collection_id = cal.collection_id
					and cal.locale_id = $localeid
					and cal.is_preferred = 1
			", $idno);
			}
		if (ereg("DOCUMENT.JMP.", $idno))
			{
			$qr_res = $o_db->query("
				SELECT DISTINCT cal.name
				FROM ca_objects cao, ca_object_labels cal
				WHERE
					cao.idno = ?
					and cao.object_id = cal.object_id
					and cal.locale_id = $localeid
					and cal.is_preferred = 1
			", $idno);
			}
		
		while($qr_res->nextRow())
			$vs_name = $qr_res->get('name');
		
		if (!$vs_name)
			return FALSE ;
		else
			return $vs_name ;
	}
	
	function getPreferredLabelIDForLocale($idno, $localeid) {
		
		$o_db = new Db(null, null, false);
		
		// now only for objects
		$qr_res = $o_db->query("
				SELECT DISTINCT cal.label_id
				FROM ca_objects cao, ca_object_labels cal
				WHERE
					cao.idno = ?
					and cao.object_id = cal.object_id
					and cal.locale_id = $localeid
					and cal.is_preferred = 1
			", $idno);
		
		while($qr_res->nextRow())
			$label_id = $qr_res->get('label_id');
		
		if (!$label_id)
			return FALSE ;
		else
			return $label_id ;
		}
		
function getListItemIDbyKeyword($keyword, $localeid = 1) {
		
		$o_db = new Db(null, null, false);
		
		// now only for objects
		$qr_res = $o_db->query("
				select li.item_id 
				from ca_list_items as li, ca_list_item_labels lil
				where li.item_id = lil.item_id
				and lil.locale_id = $localeid
				and lil.name_plural = ?
			", $keyword);
		
		while($qr_res->nextRow())
			$item_id = $qr_res->get('item_id');
		
		if (!$item_id)
			return FALSE ;
		else
			return $item_id ;
		}

function getPrimaryTypeByIdno($idno) {
		
		if (ereg("DOCUMENT.", $idno))
			$ptype = "ca_objects" ;
		if (ereg("PHOTO.", $idno))
			$ptype = "ca_objects" ;
		if (ereg("VIDEO.", $idno))
			$ptype = "ca_objects" ;
		if (ereg("INTERVIEW.", $idno))
			$ptype = "ca_objects" ;
		
		if (ereg("PERSON.", $idno))
			$ptype = "ca_entities" ;
		if (ereg("ORGANIZATION.", $idno))
			$ptype = "ca_entities" ;
		if (ereg("ORGANISATION.", $idno))
			$ptype = "ca_entities" ;
		
		if (ereg("PLACE.", $idno))
			$ptype = "ca_places" ;
			
		if (ereg("COLLECTION.", $idno))
			$ptype = "ca_collections" ;

	return ($ptype) ;
}		

function addKeywordtoObject($idno, $keyword, $autocreate = FALSE) {
	
	// load object
	$t_object = new ca_objects() ;
	$t_object->setMode(ACCESS_WRITE);
	if (!$t_object->load(array('idno' => $idno)))
		return FALSE;
	
	// FIXME: now only numeric accepted, must be a valid item_id
	// check keyword - if numeric
	
	$kid = $keyword ;
	
	/*
	// keywords list (for creation of new keywords)
	$t_list = new ca_lists();
	$t_list->load(array('list_code' => 'keywords'));
	$vn_list_id = $t_list->getPrimaryKey();
*/

	// add relationship
	$t_object->addRelationship('ca_list_items', $kid, 28); // 28 = is described by
	
	if ($t_object->numErrors()) {
						print "ERROR ADDING KEYWORD: ".join('; ', $t_object->getErrors())."\n";
						continue;
					}
}

	# ------------------------------------------------------
	function getPersonNextIdnoNum() {
		// $o_db = $this->getDb();
		$o_db = new Db(null, null, false);
		$qr_res = $o_db->query("
			select replace(idno, 'PERSON.JMP.', '') AS idno_part from ca_entities
			where idno like 'PERSON.JMP.%'
			ORDER BY CAST(replace(idno, 'PERSON.JMP.', '') AS UNSIGNED) desc
			LIMIT 1
		");
		
		while($qr_res->nextRow())
			$next_id = $qr_res->get('idno_part') + 1 ;
		
		return ($next_id);
	}

?>
