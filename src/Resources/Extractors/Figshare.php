<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\Exceptions\JournalTitleNotFoundException;

class Figshare extends Doi
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
                'title' => 'Figshare',
            ];
        }
    }

    public function extractPublicationData()
    {
        parent::extractPublicationData();

        if (empty($this->output['publication']['url'])) {
            $this->output['publication']['url'] = get_string($this->searchTree, 'id');
        }
    }
}
