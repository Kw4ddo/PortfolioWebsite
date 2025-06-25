// Dit is het profiel van de gebruiker
<?php
class UserProfile {
    private $bio;
    private $profileImage;
    private $website;

    public function __construct($bio = "", $profileImage = "", $website = "") {
        $this->bio = $bio;
        $this->profileImage = $profileImage;
        $this->website = $website;
    }

    public function getBio() {
        return $this->bio;
    }

    public function setBio($bio) {
        $this->bio = $bio;
    }

    public function getProfileImage() {
        return $this->profileImage;
    }

    public function setProfileImage($profileImage) {
        $this->profileImage = $profileImage;
    }

    public function getWebsite() {
        return $this->website;
    }

    public function setWebsite($website) {
        $this->website = $website;
    }
}
?>