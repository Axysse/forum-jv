<?php 

class Report {

    private $author;

    private $text;

    private $signalPostId;

    private $signalResponseId;

    private $reportStatus;


    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getAuthor() {   
        return $this->author;    
    }

    public function setSignalPostId($signalPostId) {
        $this->signalPostId = $signalPostId;
    }

    public function getSignalPostId() {
        return $this->signalPostId;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getText() {
        return $this->text;
    }

    public function setSignalResponseId($signalResponseId) {
        $this->signalResponseId = $signalResponseId;
    }

    public function getSignalResponseId() {
        return $this->signalResponseId;
    }

    public function setReportStatus($reportStatus) {
        $this->reportStatus = $reportStatus;
    }

    public function getReportStatus() {
        return $this->reportStatus;
    }
}