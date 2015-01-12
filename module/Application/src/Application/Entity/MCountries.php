<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MCountries
 *
 * @ORM\Table(name="m_countries")
 * @ORM\Entity
 */
class MCountries
{
    /**
     * @var integer
     *
     * @ORM\Column(name="country_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $countryId;

    /**
     * @var string
     *
     * @ORM\Column(name="country_name", type="string", length=50, nullable=false)
     */
    private $countryName;

    /**
     * @var string
     *
     * @ORM\Column(name="country_abbreviation", type="string", length=10, nullable=true)
     */
    private $countryAbbreviation;


}
