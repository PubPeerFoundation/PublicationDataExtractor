<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\Support\UpdateTypesStandardiser;
use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnparseableApiException;

class CrossrefUpdates extends Extractor implements ProvidesUpdatesData
{
    /**
     * @throws UnparseableApiException
     */
    protected function fillSearchTree(): void
    {
        if ('ok' !== $this->document['status']) {
            throw new UnparseableApiException();
        }

        if (empty($this->document['message']['items'])) {
            throw new UnparseableApiException();
        }

        $this->searchTree = $this->document['message']['items'][0];
    }

    /**
     * Extract and format data needed for the Updates Relationship
     * on the Publication Model.
     */
    public function extractUpdatesData(): void
    {
        foreach (get_array($this->searchTree, 'update-to') as $update) {
            $this->resourceOutput['updates'][] = [
                'timestamp' => $update['updated']['timestamp'],
                'identifier' => [
                    'doi' => get_string($update, 'DOI'),
                ],
                'type' => UpdateTypesStandardiser::getType($update['type']),
            ];
        }
    }
}
