<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MMaps
 *
 * @ORM\Table(name="m_maps")
 * @ORM\Entity
 */
class MMaps
{
    /**
     * @var integer
     *
     * @ORM\Column(name="map_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $mapId;

    /**
     * @var string
     *
     * @ORM\Column(name="map_url", type="string", length=255, nullable=true)
     */
    private $mapUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="map_interactive_url", type="string", length=255, nullable=true)
     */
    private $mapInteractiveUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="map_path", type="string", length=100, nullable=true)
     */
    private $mapPath;


}
