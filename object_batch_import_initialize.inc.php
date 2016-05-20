<?php

/*
 * Initialize object import. Loads models and often used values.
*/

// config

print "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx \n" ;
print "CONFIGURATION \n" ;

require_once("../ca/providence/setup.php");
	$_SERVER['HTTP_HOST'] = 'ca.localhost';

	require_once(__CA_LIB_DIR__.'/core/Db.php');
	require_once(__CA_LIB_DIR__.'/ca/Search/ListItemSearch.php');
	require_once(__CA_LIB_DIR__.'/ca/Search/OccurrenceSearch.php');
	require_once(__CA_MODELS_DIR__.'/ca_objects.php');
	require_once(__CA_MODELS_DIR__.'/ca_places.php');
	require_once(__CA_MODELS_DIR__.'/ca_locales.php');
	require_once(__CA_MODELS_DIR__.'/ca_entities.php');
	require_once(__CA_MODELS_DIR__.'/ca_occurrences.php');
	require_once(__CA_MODELS_DIR__.'/ca_entities_x_places.php');
	require_once(__CA_MODELS_DIR__.'/ca_places_x_occurrences.php');
	require_once(__CA_MODELS_DIR__.'/ca_places_x_vocabulary_terms.php');
	require_once(__CA_MODELS_DIR__.'/ca_objects_x_places.php');
	require_once(__CA_MODELS_DIR__.'/ca_objects_x_object_representations.php');
	require_once(__CA_MODELS_DIR__.'/ca_lists.php');
	require_once(__CA_MODELS_DIR__.'/ca_relationship_types.php');
	require_once(__CA_MODELS_DIR__.'/ca_collections.php');
	require_once(__CA_MODELS_DIR__.'/ca_users.php');
	require_once(__CA_LIB_DIR__.'/core/Parsers/DelimitedDataParser.php');
	
	$_ = new Zend_Translate('gettext', __CA_APP_DIR__.'/locale/en_US/messages.mo', 'en_US');

print "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx \n" ;

$t_locale = new ca_locales();
$pn_locale_id = $t_locale->loadLocaleByCode('cs_CZ');		// default locale_id

$localeid['cs_CZ'] = $t_locale->loadLocaleByCode('cs_CZ');
$localeid['en_US'] = $t_locale->loadLocaleByCode('en_US');
$localeid['de_DE'] = $t_locale->loadLocaleByCode('de_DE');
	
$t_list = new ca_lists();
$va_tmp = $t_list->getItemFromList('entity_types', 'entity_narrators');
	$entity_types['entity_narrators'] = $va_tmp['item_id'];

$va_tmp = $t_list->getItemFromList('entity_types', 'entity_interviewers');
	$entity_types['entity_interviewers'] = $va_tmp['item_id'];
	
$va_tmp = $t_list->getItemFromList('entity_types', 'entity_mentioned_old');
	$entity_types['entity_mentioned_old'] = $va_tmp['item_id'];

$va_tmp = $t_list->getItemFromList('entity_types', 'organization');
	$entity_types['organization'] = $va_tmp['item_id'];

$va_tmp = $t_list->getItemFromList('sex_types', 'F');
	$sex_types['F'] = $va_tmp['item_id'];

$va_tmp = $t_list->getItemFromList('sex_types', 'M');
	$sex_types['M'] = $va_tmp['item_id'];

$va_tmp = $t_list->getItemFromList('object_types', 'object_interview');
	$object_types['object_interview'] = $va_tmp['item_id'];

$va_tmp = $t_list->getItemFromList('object_types', 'object_photo');
	$object_types['object_photo'] = $va_tmp['item_id'];

$va_tmp = $t_list->getItemFromList('languages_list', 'CZE');
	$languages_list['CZE'] = $va_tmp['item_id'];

$va_tmp = $t_list->getItemFromList('languages_list', 'GER');
	$languages_list['GER'] = $va_tmp['item_id'];

$va_tmp = $t_list->getItemFromList('languages_list', 'ENG');
	$languages_list['ENG'] = $va_tmp['item_id'];

$va_tmp = $t_list->getItemFromList('entity_date_types', 'birthdate');
	$entity_date_types['birthdate'] = $va_tmp['item_id'];

$va_tmp = $t_list->getItemFromList('boolean_types', 'true');
	$boolean_types['TRUE'] = $va_tmp['item_id'];

$va_tmp = $t_list->getItemFromList('boolean_types', 'false');
	$boolean_types['FALSE'] = $va_tmp['item_id'];

$va_tmp = $t_list->getItemFromList('collection_types', 'archival');
	$collection_types['archival'] = $va_tmp['item_id'];

$occurrence_types['occ_transport'] = 		$t_list->getItemIDFromList('occurrence_types', 'occ_transport');
$id_statuses['valid'] = 		$t_list->getItemIDFromList('id_statuses', 'valid');
$id_statuses['old'] = 		$t_list->getItemIDFromList('id_statuses', 'old');
$id_types['call_number'] = 		$t_list->getItemIDFromList('id_types', 'call_number');
$id_types['inv_number'] = 		$t_list->getItemIDFromList('id_types', 'inv_number');
$id_types['acq_number'] = 		$t_list->getItemIDFromList('id_types', 'acq_number');
$id_types['photo_number'] = 		$t_list->getItemIDFromList('id_types', 'photo_number');
$id_types['interview_number'] = 		$t_list->getItemIDFromList('id_types', 'interview_number');
$id_types['book_number'] = 		$t_list->getItemIDFromList('id_types', 'book_number');
$name_types['TIT'] = 		$t_list->getItemIDFromList('name_types', 'TIT');
$name_types['SBO'] = 		$t_list->getItemIDFromList('name_types', 'SBO');
$name_types['SFO'] = 		$t_list->getItemIDFromList('name_types', 'SFO');
$name_types['FFO'] = 		$t_list->getItemIDFromList('name_types', 'FFO');
$name_types['FBO'] = 		$t_list->getItemIDFromList('name_types', 'FBO');

$collection_types['archival_JMP'] = $t_list->getItemIDFromList('collection_types', 'archival_JMP');	
$object_types['object_document'] = $t_list->getItemIDFromList('object_types', 'object_document');	
$object_types['object_document_JMP'] = $t_list->getItemIDFromList('object_types', 'document_JMP');	

$keywords['emigration'] = 		$t_list->getItemIDFromList('keywords', 'emigration');
$keywords['hiding'] = 		$t_list->getItemIDFromList('keywords', 'hiding');
$keywords['imprisonment'] = 		$t_list->getItemIDFromList('keywords', 'imprisonment');
$keywords['death_march'] = 		$t_list->getItemIDFromList('keywords', 'death_march');
$keywords['internment'] = 		$t_list->getItemIDFromList('keywords', 'internment');
$keywords['army'] = 		$t_list->getItemIDFromList('keywords', 'army');
$keywords['resistance_domestic'] = 		$t_list->getItemIDFromList('keywords', 'resistance_domestic');
$keywords['resistance_abroad'] = 		$t_list->getItemIDFromList('keywords', 'resistance_abroad');
$keywords['survival_at_home'] = 		$t_list->getItemIDFromList('keywords', 'survival_at_home');
$keywords['escape'] = 		$t_list->getItemIDFromList('keywords', 'escape');
$keywords['arrest'] = 		$t_list->getItemIDFromList('keywords', 'arrest');
$keywords['deportation'] = 		$t_list->getItemIDFromList('keywords', 'deportation');

$nuremberg_laws_category_types['jew'] = 		$t_list->getItemIDFromList('nuremberg_laws_category_types', 'jew');
$nuremberg_laws_category_types['aryan'] = 		$t_list->getItemIDFromList('nuremberg_laws_category_types', 'aryan');
$nuremberg_laws_category_types['mischling'] = 		$t_list->getItemIDFromList('nuremberg_laws_category_types', 'mischling');

$languages['CZE'] = 		$t_list->getItemIDFromList('languages_list', 'CZE');
$languages['GER'] = 		$t_list->getItemIDFromList('languages_list', 'GER');
$languages['HEB'] = 		$t_list->getItemIDFromList('languages_list', 'HEB');
$languages['ITA'] = 		$t_list->getItemIDFromList('languages_list', 'ITA');
$languages['POL'] = 		$t_list->getItemIDFromList('languages_list', 'POL');

$representation_types['original'] = 		$t_list->getItemIDFromList('representation_types', 'original');
$representation_types['transcript'] = 		$t_list->getItemIDFromList('representation_types', 'transcript');

$representation_editing_statuses['original'] = 		$t_list->getItemIDFromList('representation_editing_statuses', 'original');
$representation_editing_statuses['edited'] = 		$t_list->getItemIDFromList('representation_editing_statuses', 'edited');
$representation_editing_statuses['anonymised'] = 		$t_list->getItemIDFromList('representation_editing_statuses', 'anonymised');

$document_character_types['manuscript'] = 		$t_list->getItemIDFromList('document_character_types', 'manuscript');
$document_character_types['typescript'] = 		$t_list->getItemIDFromList('document_character_types', 'typescript');
$document_character_types['transcript'] = 		$t_list->getItemIDFromList('document_character_types', 'transcript');

$originality_types['original'] = 		$t_list->getItemIDFromList('originality_types', 'original');
$originality_types['copy'] = 		$t_list->getItemIDFromList('originality_types', 'copy');

$t_rel_types = new ca_relationship_types();
$relationship_types['ca_objects_x_entities_narrator'] = $t_rel_types->getRelationshipTypeID('ca_objects_x_entities', 'narrator');
$relationship_types['ca_objects_x_entities_interviewer'] = $t_rel_types->getRelationshipTypeID('ca_objects_x_entities', 'interviewer');
$relationship_types['ca_objects_x_entities_described'] = $t_rel_types->getRelationshipTypeID('ca_objects_x_entities', 'describes');
$relationship_types['ca_objects_x_collections_part_of'] = $t_rel_types->getRelationshipTypeID('ca_objects_x_collections', 'part_of');
$relationship_types['ca_entities_x_occurrences_deported'] = $t_rel_types->getRelationshipTypeID('ca_entities_x_occurrences', 'deported');
$relationship_types['ca_places_x_occurrences_started_at'] = $t_rel_types->getRelationshipTypeID('ca_places_x_occurrences', 'started_at');
$relationship_types['ca_places_x_occurrences_ended_at'] = $t_rel_types->getRelationshipTypeID('ca_places_x_occurrences', 'ended_at');
$relationship_types['ca_entities_x_vocabulary_terms_described'] = $t_rel_types->getRelationshipTypeID('ca_entities_x_vocabulary_terms', 'described');
$relationship_types['ca_objects_x_vocabulary_terms_described'] = $t_rel_types->getRelationshipTypeID('ca_objects_x_vocabulary_terms', 'described');
$relationship_types['ca_objects_x_places_describes'] = $t_rel_types->getRelationshipTypeID('ca_objects_x_places', 'describes');
$relationship_types['ca_objects_x_occurrances_described_by'] = $t_rel_types->getRelationshipTypeID('ca_objects_x_occurrances', 'described_by');
$relationship_types['ca_objects_x_objects_related'] = $t_rel_types->getRelationshipTypeID('ca_objects_x_objects', 'related');

$access_values = array() ;
$access_values["public"] = 1433 ;
$access_values["restricted"] = 1434 ;
$access_values["not_public"] = 1435 ;

?>
