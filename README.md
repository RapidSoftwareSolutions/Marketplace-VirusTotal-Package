[![](https://scdn.rapidapi.com/RapidAPI_banner.png)](https://rapidapi.com/package/VirusTotal/functions?utm_source=RapidAPIGitHub_VirusTotalFunctions&utm_medium=button&utm_content=RapidAPI_GitHub)
# VirusTotal Package
* Domain: [https://virustotal.com/](https://https://virustotal.com/)
* Credentials: apikey

## How to get credentials: 
1. [Sign up](https://www.virustotal.com/#signup) and go to "My API Key" page
 
## VirusTotal.scanFiles
Send file to VirusTotal

| Field | Type       | Description
|-------|------------|----------
| apikey| credentials| VirusTotal apikey
| file  | File       | File to scan

## VirusTotal.rescanFiles
Rescanning already submitted files

| Field   | Type       | Description
|---------|------------|----------
| apikey  | credentials| VirusTotal apikey
| resource| Array      | List of a md5/sha1/sha256 hash. Up to 25 items, this allows you to perform a batch request with one single call. Note that the file must already be present in our file store.

## VirusTotal.getFileScanReport
Retrieving file scan reports

| Field   | Type       | Description
|---------|------------|----------
| apikey  | credentials| VirusTotal apikey
| resource| Array      | List of a md5/sha1/sha256 hash. Up to 25 items, this allows you to perform a batch request with one single call. Note that the file must already be present in our file store.

## VirusTotal.scanURLs
Sending and scanning URLs

| Field | Type       | Description
|-------|------------|----------
| apikey| credentials| VirusTotal apikey
| urls  | Array      | This parameter accepts a list of URLs (up to 4 with the standard request rate) so as to perform a batch scanning request with one single call.

## VirusTotal.getURLscanReport
Retrieving URL scan reports

| Field   | Type       | Description
|---------|------------|----------
| apikey  | credentials| VirusTotal apikey
| resource| Array      | List of a scan_id. Up to 4 items, this allows you to perform a batch request with one single call. Note that the file must already be present in our file store.
| scan    | Boolean    | True -  will automatically submit the URL for analysis if no report is found for it in VirusTotal's database. In this case the result will contain a scan_id field that can be used to query the analysis report later on.

## VirusTotal.getReportIP
Retrieving IP address reports

| Field | Type       | Description
|-------|------------|----------
| apikey| credentials| VirusTotal apikey
| ip    | String     | A valid IPv4 address in dotted quad notation, for the time being only IPv4 addresses are supported.

## VirusTotal.getDomainReport
Retrieving domain reports

| Field | Type       | Description
|-------|------------|----------
| apikey| credentials| VirusTotal apikey
| domain| String     | A domain name.

## VirusTotal.makeComment
Make comments on files and URLs

| Field   | Type       | Description
|---------|------------|----------
| apikey  | credentials| VirusTotal apikey
| resource| String     | Either a md5/sha1/sha256 hash of the file you want to review or the URL itself that you want to comment on.
| comment | String     | the actual review, you can tag it using the "#" twitter-like syntax (e.g. #disinfection #zbot) and reference users using the "@" syntax (e.g. @VirusTotalTeam)

