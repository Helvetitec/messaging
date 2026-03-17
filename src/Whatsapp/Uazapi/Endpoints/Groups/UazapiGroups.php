<?php

namespace Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\Groups;

use Exception;
use Helvetitec\Messaging\Enums\Uazapi\GroupParticipantAction;
use Helvetitec\Messaging\Whatsapp\Uazapi\Endpoints\UazapiInstanceEndpoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class UazapiGroups extends UazapiInstanceEndpoint
{
    /**
     * Creates a new group with a name and its participants. The current user will already be one of the participants!
     * The participants need to be a list of international phonenumbers.
     * 
     * @todo Return correct format
     * @param string $name
     * @param array $participants
     * @return array
     */
    public function create(string $name, array $participants): array
    {
        $url = $this->root().'group/create';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'name' => $name,
            'participants' => $participants
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Fetches informations about a certain group. If force is set to true the data will be fetched again, 
     * not taken from the servers cache.
     *
     * @todo Return correct format
     * @param string $groupJid
     * @param boolean $getInviteLink
     * @param boolean $getRequestsParticipants
     * @param boolean $force
     * @return array
     */
    public function get(string $groupJid, bool $getInviteLink, bool $getRequestsParticipants, bool $force): array
    {
        $url = $this->root().'group/info';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'groupjid' => $groupJid,
            'getInviteLink' => $getInviteLink,
            'getRequestsParticipants' => $getRequestsParticipants,
            'force' => $force
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Fetches informations about a certain group per invite code.
     *
     * @todo Return correct format
     * @param string $inviteCode
     * @return array
     */
    public function getByInvite(string $inviteCode): array
    {
        $url = $this->root().'group/inviteInfo';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'invitecode' => $inviteCode
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Group for invite code \"{$inviteCode}\" not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json();
    }

    /**
     * Enters a group with an invitation code and returns the groups informations
     *
     * @todo Return correct format
     * @param string $inviteCode
     * @return array
     */
    public function enterWithInvite(string $inviteCode): array
    {
        $url = $this->root().'group/join';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'invitecode' => $inviteCode
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] Access for user not granted!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json('group');
    }

    /**
     * Leaves a group with a specific groupJid.
     *
     * @param string $groupJid
     * @return true
     */
    public function leave(string $groupJid): true
    {
        $url = $this->root().'group/leave';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'groupjid' => $groupJid
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Returns a list of all groups.
     * 
     * @todo Return correct format, not only a collection of arrays
     * @return Collection
     */
    public function list(): Collection
    {
        $url = $this->root().'group/list';
        $response = Http::asJson()->withHeader('token', $this->token)->get($url);

        if(!$response->successful()){
            $status = $response->status();
            $body = $response->body();
            throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");            
        }

        return collect($response->json('groups'));
    }

    /**
     * Returns an array with a paginated list of groups as collection and more informations about the pagination
     *
     * @todo Return correct format. We do only return a collection of arrays in groups.
     * @param integer $page
     * @param integer $pageSize
     * @param integer $limit
     * @param integer $offset
     * @param string $search
     * @param boolean $force
     * @param boolean $noParticipants
     * @return array [groups, pagination]
     */
    public function paginated(int $page, int $pageSize, int $limit, int $offset, string $search, bool $force, bool $noParticipants): array
    {
        $url = $this->root().'group/list';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'page' => $page,
            'pageSize' => $pageSize,
            'limit' => $limit,
            'offset' => $offset,
            'search' => $search,
            'force' => $force,
            'noParticipants' => $noParticipants
        ]);

        if(!$response->successful()){
            $status = $response->status();
            $body = $response->body();
            throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
        }

        return [
            'groups' => collect($response->json('groups')),
            'pagination' => $response->json('pagination'),
        ];
    }
    
    /**
     * Resets the invite link for the group an returns the new one. User needs to be group admin to do this action.
     *
     * @param string $groupJid
     * @return string
     */
    public function resetInvite(string $groupJid): string
    {
        $url = $this->root().'group/resetInviteCode';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'groupjid' => $groupJid
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] User does not have permissions to reset invite code!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json('InviteLink');
    }

    /**
     * Configures the permissions if all users can write messages or only the admins (announce = true). The user
     * needs to be admin to do this action.
     *
     * @param string $groupJid
     * @param boolean $annouce
     * @return boolean
     */
    public function configMessagePermissions(string $groupJid, bool $announce): bool
    {
        $url = $this->root().'group/updateAnnounce';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'groupjid' => $groupJid,
            'announce' => $announce
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] User does not have permissions to reset invite code!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Update the description of the group. User has to be admin of the group to do that.
     *
     * @param string $groupJid
     * @param string $description
     * @return boolean
     */
    public function editDescription(string $groupJid, string $description): bool
    {
        $url = $this->root().'group/updateDescription';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'groupjid' => $groupJid,
            'description' => $description
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] User does not have permissions to reset invite code!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Group not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Update the image of the group. User needs to be an admin to do this action.
     *
     * @param string $groupJid
     * @param string $image Valid values: Url, Base64, 'remove', 'delete'
     * @return bool
     */
    public function editImage(string $groupJid, string $image): bool
    {
        $url = $this->root().'group/updateImage';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'groupjid' => $groupJid,
            'image' => $image
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] User does not have permissions to reset invite code!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Group not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Update permissions to edit group informations for all users.
     *
     * @param string $groupJid
     * @param boolean $locked
     * @return bool
     */
    public function configEditPermissions(string $groupJid, bool $locked): bool
    {
        $url = $this->root().'group/updateLocked';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'groupjid' => $groupJid,
            'locked' => $locked
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] User does not have permissions to reset invite code!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Group not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Update the name of the group. The user has to be admin to do that action.
     *
     * @param string $groupJid
     * @param string $name
     * @return bool
     */
    public function editName(string $groupJid, string $name): bool
    {
        $url = $this->root().'group/updateName';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'groupjid' => $groupJid,
            'name' => $name
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] User does not have permissions to reset invite code!");
            }elseif($response->status() == 404){
                throw new Exception("[UAZAPI] Group not found!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Updates a bunch of participants from a group per GroupParticipantAction.
     *
     * @param string $groupJid
     * @param GroupParticipantAction $action
     * @param array $participants
     * @return void
     */
    public function manageGroupContacts(string $groupJid, GroupParticipantAction $action, array $participants)
    {
        $url = $this->root().'group/updateParticipants';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'groupjid' => $groupJid,
            'action' => $action->value,
            'participants' => $participants
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] User does not have permissions to reset invite code!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return true;
    }

    /**
     * Creates a community and returns the group array of it.
     *
     * @todo Return correct format
     * @param string $name
     * @return array
     */
    public function createCommunity(string $name): array
    {
        $url = $this->root().'community/create';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'name' => $name
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] User does not have permissions to create communities!");
            }elseif($response->status() == 429){
                throw new Exception("[UAZAPI] Group creation limit reached!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return $response->json('group');
    }

    /**
     * Updates the groups in the community and returns an array of [success, failed].
     *
     * @param string $communityJid
     * @param boolean $add
     * @param array $groupJids
     * @return array
     */
    public function editGroupsInCommunity(string $communityJid, bool $add, array $groupJids): array
    {
        $action = $add ? 'add' : 'remove';

        $url = $this->root().'community/create';
        $response = Http::asJson()->withHeader('token', $this->token)->post($url, [
            'community' => $communityJid,
            'action' => $action,
            'groupJids' => $groupJids
        ]);

        if(!$response->successful()){
            if($response->status() == 400){
                throw new Exception("[UAZAPI] Invalid payload! - ".$response->body());
            }elseif($response->status() == 401){
                throw new Exception("[UAZAPI] Invalid token!");
            }elseif($response->status() == 403){
                throw new Exception("[UAZAPI] User does not have permissions to create communities!");
            }else{
                $status = $response->status();
                $body = $response->body();
                throw new Exception("[UAZAPI] Failed with status {{ $status }}: {{ $body }}");
            }
        }

        return [
            'success' => $response->json('success'),
            'failed' => $response->json('failed')
        ];
    }

}
