<?php

/**
 * Class Competitor
 * class representing WCA competitor
 */
class Competitor
{
    const WORLD_RANK = 'world_rank';
    const CONTINENT_RANK = 'continent_rank';
    const COUNTRY_RANK = 'country_rank';
    protected $name;
    protected $wcaId;
    protected $url;
    protected $gender;
    //TODO: add dictionary with polish and english country names
    protected $country; //contains ISO-2 Country code
    protected $delegateStatus;
    protected $avatar;
    protected $avatarThumb;
    protected $isDefaultAvatar;
    protected $personalRecords;

    /**
     * Competitor constructor.
     * @param object $jsonPersonObject object got from WCA API
     */
    public function __construct($jsonPersonObject)
    {
        $this->setPersonalFields($jsonPersonObject->person);
        $this->personalRecords = $jsonPersonObject->personal_records;
    }

    private function setPersonalFields($personApiObject)
    {
        $this->name = $personApiObject->name;
        $this->wcaId = $personApiObject->wca_id;
        $this->url = $personApiObject->url;
        $this->gender = $personApiObject->gender;
        $this->country = $personApiObject->country_iso2;
        $this->delegateStatus = $personApiObject->delegate_status;
        $this->avatar = $personApiObject->avatar->url;
        $this->avatarThumb = $personApiObject->avatar->thumb_url;
        $this->isDefaultAvatar = $personApiObject->avatar->is_default;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getWcaId()
    {
        return $this->wcaId;
    }

    /**
     * @return string url to competitors profile on worldcubeassociation.org
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string m for males or f for females
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $language
     * @return string
     */
    public function getCountryName($language)
    {
        //TODO: implement after dictionary is designed
    }

    /**
     * @return string
     * Show delegate rank of a competitor
     */
    public function getDelegateStatus()
    {
        return $this->delegateStatus;
    }

    /**
     * @return bool
     * Check if a competitor is a WCA Delegate
     */
    public function isDelegate()
    {
        return $this->delegateStatus ? true : false;
    }

    /**
     * @return bool checks if a competitor has a customized avatar on WCA Profile
     */
    public function hasAvatar()
    {
        return $this->isDefaultAvatar;
    }
    /**
     * @return string
     * link to competitors avatar on WCA profile
     * note that if competitor did not set up his avatar this method will return
     * default avatar for WCA page
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @return string
     * note that if competitor did not set up his avatar this method will return
     * default avatar thumb for WCA page
     */
    public function getAvatarThumb()
    {
        return $this->avatarThumb;
    }

    /**
     * @param $eventId
     * @return int|bool competitors best single in given event
     * in miliseconds. If event id does not exist for this competitor
     * ( e.g. he or she didn't participated successfully in this event)
     * it returns FALSE
     */
    public function getSingle($eventId)
    {
        if($this->hasSingle($eventId))
            return $this->personalRecords->$eventId->single->best;
        else return false;
    }

    /**
     * @param $eventId
     * @return bool
     * checks if the competitor has single in given event
     */
    protected function hasSingle($eventId)
    {
        return $this->personalRecords->$eventId ? true : false;
    }

    /**
     * @param string $eventId
     * @return int|bool competitors best average in given event
     * in miliseconds. If event id does not exist for this competitor
     * ( e.g. he or she have not done average in this event)
     * it returns FALSE
     */
    public function getAverage($eventId)
    {
        if($this->hasAverage($eventId))
            return $this->personalRecords->$eventId->average->best;
        else return false;
    }

    /**
     * @param $eventId
     * @return bool
     * checks if the competitor has average in given event
     */
    protected function hasAverage($eventId)
    {
        return $this->personalRecords->$eventId && $this->personalRecords->$eventId->average ? true : false;
    }

    public function getSingleRanking($eventId, $rankingType)
    {
        if($this->hasSingle($eventId) &&
            ($rankingType == self::WORLD_RANK || $rankingType == self::CONTINENT_RANK || $rankingType == self::COUNTRY_RANK))
            return $this->personalRecords->$eventId->single->$rankingType;
        else return false;
    }

    public function getAverageRanking($eventId, $rankingType)
    {
        if($this->hasAverage($eventId) &&
            ($rankingType == self::WORLD_RANK || $rankingType == self::CONTINENT_RANK || $rankingType == self::COUNTRY_RANK))
            return $this->personalRecords->$eventId->average->$rankingType;
        else return false;
    }

}