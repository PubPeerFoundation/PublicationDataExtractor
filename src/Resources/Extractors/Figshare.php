<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\Exceptions\JournalTitleNotFoundException;

class Figshare extends Doi
{
    /**
     * Extract and format data needed for the Journals Relationship
     * on the Publication Model.
     */
    public function extractJournalData(): void
    {
        try {
            parent::extractJournalData();
        } catch (JournalTitleNotFoundException $e) {
            $this->resourceOutput['journal'] = [
                'title' => 'Figshare',
            ];
        }
    }

    /**
     * Extract and format data needed for the Publication Model.
     */
    public function extractPublicationData(): void
    {
        parent::extractPublicationData();

        if (empty($this->resourceOutput['publication']['url'])) {
            $this->resourceOutput['publication']['url'] = get_string($this->searchTree, 'id');
        }
    }
}
