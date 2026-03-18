<?php

namespace Helvetitec\Messaging\Whatsapp\Data\Uazapi;

class GroupData
{
    /**
     * Groups Jid
     *
     * @var string
     */
    public readonly string $jid;
    /**
     * Jid of the group owner
     *
     * @var string
     */
    public readonly string $ownerJid;
    /**
     * Phone number or Lid of the owner
     *
     * @var string
     */
    public readonly string $ownerPn;
    /**
     * Name of the group
     *
     * @var string
     */
    public readonly string $name;
    /**
     * Date of the last name change
     *
     * @var string
     */
    public readonly string $nameSetAt;
    /**
     * Jid of the user that changed the name
     *
     * @var string
     */
    public readonly string $nameSetBy;
    /**
     * Pn or Lid of the user last changed the name
     *
     * @var string
     */
    public readonly string $nameSetByPn;
    /**
     * The description of the group
     * 
     * @var string
     */
    public readonly string $topic;
    /**
     * Internal id of the description
     *
     * @var string
     */
    public readonly string $topicId;
    /**
     * Date of the last change of the description
     *
     * @var string
     */
    public readonly string $topicSetAt;
    /**
     * Jid of the user that last changed the description
     *
     * @var string
     */
    public readonly string $topicSetBy;
    /**
     * Lid/ phone number of the user that last changed the description
     *
     * @var string
     */
    public readonly string $topicSetByPn;
    /**
     * Was the description removed?
     *
     * @var boolean
     */
    public readonly bool $topicDeleted;
    /**
     * If true, only admins can edit group informations
     *
     * @var boolean
     */
    public readonly bool $isLocked;
    /**
     * If true only admins can write messages
     *
     * @var boolean
     */
    public readonly bool $isAnnounce;
    /**
     * Version of the configurations of the announcements
     *
     * @var string
     */
    public readonly string $announceVersionId;
    /**
     * Are the messages temporary?
     *
     * @var boolean
     */
    public readonly bool $isEphemeral;
    /**
     * Time in seconds until the messages disappear
     *
     * @var integer
     */
    public readonly int $disappearingTimer;
    /**
     * Is the group incognito?
     *
     * @var boolean
     */
    public readonly bool $isIncognito;
    /**
     * Is the group a community?
     *
     * @var boolean
     */
    public readonly bool $isParent;
    /**
     * Is approval necessary to join the group?
     *
     * @var boolean
     */
    public readonly bool $isJoinApprovalRequired;
    /**
     * Jid of the connected community
     *
     * @var string
     */
    public readonly string $linkedParentJid;
    /**
     * Is the group the default subgroup of the community?
     *
     * @var boolean
     */
    public readonly bool $isDefaultSubGroup;
    /**
     * The default membership approval mode
     *
     * @var string
     */
    public readonly string $defaultMembershipApprovalMode;
    /**
     * Date of the creation of the group 
     *
     * @var string
     */
    public readonly string $groupCreated;
    /**
     * Country code of the creator of the group
     *
     * @var string
     */
    public readonly string $creatorCountryCode;
    /**
     * Version of the list of participants
     *$
     * @var string
     */
    public readonly string $participantVersionId;
    /**
     * List of participants
     *
     * @var array
     */
    public readonly array $participants;
    /**
     * Mode to add new members
     *
     * @var string
     */
    public readonly string $memberAddMode;
    /**
     * Prefered addressing mode of the group
     *
     * @var string
     */
    public readonly string $addressingMode;
    /**
     * Can the current user send a message?
     *
     * @var boolean
     */
    public readonly bool $ownerCanSendMessage;
    /**
     * Is the current user admin?
     *
     * @var boolean
     */
    public readonly bool $ownerIsAdmin;
    /**
     * Id of the default subgroup of the community
     *
     * @var string
     */
    public readonly string $defaultSubGroupId;
    /**
     * Invite link
     *
     * @var string
     */
    public readonly string $inviteLink;
    /**
     * List of participant requests
     *
     * @var string
     */
    public readonly string $requestParticipants;

    public function __construct(array $payload)
    {
        $this->jid = $payload['JID'];
        $this->ownerJid = $payload['OwnerJID'];
        $this->ownerPn = $payload['OwnerPN'];
        $this->name = $payload['Name'];
        $this->nameSetAt = $payload['NameSetAt'];
        $this->nameSetBy = $payload['NameSetBy'];
        $this->nameSetByPn = $payload['NameSetByPN'];
        $this->topic = $payload['Topic'];
        $this->topicId = $payload['TopicID'];
        $this->topicSetAt = $payload['TopicSetAt'];
        $this->topicSetBy = $payload['TopicSetBy'];
        $this->topicSetByPn = $payload['TopicSetByPN'];
        $this->topicDeleted = $payload['TopicDeleted'];
        $this->isLocked = $payload['IsLocked'];
        $this->isAnnounce = $payload['IsAnnounce'];
        $this->announceVersionId = $payload['AnnounceVersionID'];
        $this->isEphemeral = $payload['IsEphemeral'];
        $this->disappearingTimer = $payload['DisappearingTimer'];
        $this->isIncognito = $payload['IsIncognito'];
        $this->isParent = $payload['IsParent'];
        $this->isJoinApprovalRequired = $payload['IsJoinApprovalRequired'];
        $this->linkedParentJid = $payload['LinkedParentJID'];
        $this->isDefaultSubGroup = $payload['IsDefaultSubGroup'];
        $this->defaultMembershipApprovalMode = $payload['DefaultMembershipApprovalMode'];
        $this->groupCreated = $payload['GroupCreated'];
        $this->creatorCountryCode = $payload['CreatorCountryCode'];
        $this->participantVersionId = $payload['ParticipantVersionID'];
        $this->participants = $payload['Participants'];
        $this->memberAddMode = $payload['MemberAddMode'];
        $this->addressingMode = $payload['AddressingMode'];
        $this->ownerCanSendMessage = $payload['OwnerCanSenMessage'];
        $this->ownerIsAdmin = $payload['OwnerIsAdmin'];
        $this->defaultSubGroupId = $payload['DefaultSubGroupId'];
        $this->inviteLink = $payload['invite_link'];
        $this->requestParticipants = $payload['request_participants'];
    }
}