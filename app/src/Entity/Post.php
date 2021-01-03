<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=128)
     * @Assert\Length(max=128, groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=128)
     * @Assert\Length(max=128, groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     */
    protected $author;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    protected $category;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank(groups={"create"})
     */
    protected $content;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank(groups={"create"})
     */
    protected $city;

    /**
     * @var string|null
     *
     * @ORM\Column(type="decimal", precision=11, scale=8, nullable=true)
     */
    private $latitude;

    /**
     * @var string|null
     *
     * @ORM\Column(type="decimal", precision=11, scale=8, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=32)
     * @Assert\Length(max=32, groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    protected $intent;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=12, nullable=false)
     */
    protected $deactivationToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=128)
     * @Assert\Length(max=128)
     * @Assert\NotBlank()
     */
    protected $slug;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true, "default":0})
     */
    protected $views = 0;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Post
     */
    public function setId(?int $id): Post
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Post
     */
    public function setTitle(string $title): Post
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return Post
     */
    public function setAuthor(string $author): Post
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     * @return Post
     */
    public function setCategory(string $category): Post
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Post
     */
    public function setCity(string $city): Post
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    /**
     * @param string|null $latitude
     * @return Post
     */
    public function setLatitude(?string $latitude): Post
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * @param string|null $longitude
     * @return Post
     */
    public function setLongitude(?string $longitude): Post
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @param string $content
     * @return Post
     */
    public function setContent(string $content): Post
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Post
     */
    public function setPhone(string $phone): Post
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getIntent(): string
    {
        return $this->intent;
    }

    /**
     * @param string $intent
     * @return Post
     */
    public function setIntent(string $intent): Post
    {
        $this->intent = $intent;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Post
     */
    public function setStatus(string $status): Post
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getDeactivationToken(): string
    {
        return $this->deactivationToken;
    }

    /**
     * @param string $deactivationToken
     * @return Post
     */
    public function setDeactivationToken(string $deactivationToken): Post
    {
        $this->deactivationToken = $deactivationToken;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Post
     */
    public function setCreatedAt(\DateTime $createdAt): Post
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Post
     */
    public function setSlug(string $slug): Post
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return int
     */
    public function getViews(): int
    {
        return $this->views;
    }

    /**
     * @param int $views
     * @return Post
     */
    public function setViews(int $views): Post
    {
        $this->views = $views;
        return $this;
    }
}
