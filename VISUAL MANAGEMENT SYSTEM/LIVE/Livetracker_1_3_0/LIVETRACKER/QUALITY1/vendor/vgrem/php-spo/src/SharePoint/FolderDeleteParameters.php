<?php

/**
 * Generated 2019-10-12T18:54:53+00:00 16.0.19402.12016
 */
namespace Office365\SharePoint;

use Office365\Runtime\ClientValue;

class FolderDeleteParameters extends ClientValue
{
    /**
     * @var bool
     */
    public $BypassSharedLock;
    /**
     * @var bool
     */
    public $DeleteIfEmpty;
    /**
     * @var string
     */
    public $ETagMatch;
}