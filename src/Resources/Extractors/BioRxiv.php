<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\Exceptions\JournalTitleNotFoundException;

class BioRxiv extends Crossref
{
    /**
     * Extract and format data needed for the Journals Relationship
     * on the Publication Model.
     */
    public function extractJournalData()
    {
        try {
            parent::extractJournalData();
        } catch (JournalTitleNotFoundException $e) {
            $this->output['journal'] = [
                'title' => 'BioRxiv',
            ];
        }
    }
}
