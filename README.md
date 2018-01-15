# Publication Data Extractor

The main idea behind this package is to allow the extraction of Research Publication data from any external API into a simple common structure.

The package can identify multiple types of identifiers such as DOI, PubMed Id, arXiv ID, ...

The package can then read from different external APIs such as doi.org, crossref api, ncbi, arXiv.org, ...

The resulting structure looks like this:

```
{
    "authors":[
        {
            "first_name":"Richard S.",
            "last_name":"Smith",
            "orcid":null,
            "affiliation":[{
                "name":"Department of Biology, University of Maryland, College Park, Maryland"
            }]
        },
        {
            "first_name":"Ricardo C.",
            "last_name":"Araneda",
            "orcid":null,
            "affiliation":[{
                "name":"Department of Biology, University of Maryland, College Park, Maryland"
            }]
        }
    ],
    "identifiers":[
        {
            "value":"10.1152\/jn.00446.2010",
            "type":"doi"
        },
        {
            "value":"0022-3077",
            "type":"issn"
        },
        {
            "value":"1522-1598",
            "type":"issn"
        }
    ],
    "journal":{
        "title":"Journal of Neurophysiology",
        "issn":["0022-3077","1522-1598"],
        "publisher":"American Physiological Society"
    },
    "publication":{
        "title":"Cholinergic Modulation of Neuronal Excitability in the Accessory Olfactory Bulb",
        "abstract":null,
        "url":"http:\/\/dx.doi.org\/10.1152\/jn.00446.2010",
        "published_at":"2010-12"
    },
    "tags": [
        {
            "name":"Physiology"
        },
        {
            "name":"General Neuroscience"
        }
    ],
    "types":[
        {
            "name":"journal-article"
        }
    ]
}
```