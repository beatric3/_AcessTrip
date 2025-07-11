<?php
class ClassLocalCaracteristica {
    private $id;
    private $localId;
    private $caracteristicaId;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getLocalId() { return $this->localId; }
    public function setLocalId($localId) { $this->localId = $localId; }

    public function getCaracteristicaId() { return $this->caracteristicaId; }
    public function setCaracteristicaId($caracteristicaId) { $this->caracteristicaId = $caracteristicaId; }
}
