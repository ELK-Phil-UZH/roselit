﻿<?php

require_once("DocumentList.php");

class DocumentListMapper extends CI_Model{

	private $tableName = "documentlists"; // Name of database table
	private $docToListTable = "documents2lists"; // Name of mapping table

	public function save(DocumentList $pDocList){
		// Table "documents"		
		$lData = array("title" => $pDocList->getTitle(),
					   "createdBy" => $pDocList->getCreator()->getId(),
					   "managedBy" => $pDocList->getAdmin()->getId());
		if($pDocList->isNew()){
			$lData["created"] = null;
			$this->db->insert($this->tableName, $lData);
			$pDocList->setId($this->db->insert_id()); // Add id generated by database to the doc list object
		}
		else{
			$this->db->where("id", $pDocList->getId());
			$this->db->update($this->tableName, $lData);
		}
		
		// Table "documents2lists"
		$lDocListId = $pDocList->getId();
		// Delete all mapping entries
		$this->db->delete($this->docToListTable, array("listId" => $lDocListId)); 
		$lListData = array();		
		foreach($pDocList->getDocumentIds() as $lDocumentId){
			$lListData[] = array("documentListId" => $lDocListId,
								 "documentId" => $lDocumentId);
		}
		// Rewrite all mapping entries
		$this->db->insert_batch($this->docToListTable, $lListData);
	}

	public function delete($pDocList){
		if(!($pDocList->isNew())){
			$this->db->delete($this->tableName, array("id" => $pDocList->getId()));
			$this->db->delete($this->docToListTable, array("listId" => $pDocList->getId()));
		}
	}
	
	public function get($pId){
		$lQuery = $this->db->get_where($this->tableName, array("id", $pId));
		if($lQuery->num_rows() == 1){
			$lResult = $lQuery->row();
			$lDocList = new DocumentList($lResult->title, $lResult->creatorId);
			$lDocList->setId($lResult->id);
			$lDocList->setAdmin($lResult->adminId);
			$lDocList->setLastUpdated(DateTime::createFromFormat("Y-m-d H:i:s"));
			$lDocList->setCreated(DateTime::createFromFormat("Y-m-d H:i:s"));
		}
		return $lDocList;
	}

}