<?php

namespace App\Traits;

use App\Models\Lead;
use App\Models\LeadGroup;

trait HasLeads
{
    /**
     * Many-to-Many relations with Lead.
     */
    public function leads()
    {
        return $this->morphToMany(Lead::class, 'owner', 'leads_owns', 'owner_id', 'lead_id');
    }

    /**
     * Many-to-Many relations with LeadGroup.
     */
    public function leadGroups()
    {
        return $this->morphToMany(LeadGroup::class, 'owner', 'lead_groups_owns', 'owner_id', 'lead_group_id');
    }

    /**
     * Get the all user's leads.
     * getAllLeads()
     */
    public function getAllLeads($leadGroupCode = 'all')
    {
        //вернуть все лиды доступные пользователю
        if ($leadGroupCode == 'all') {
            //все лиды, прикрепленные к пользователю
            $userLeads = $this->leads;
            //все лиды, доступные пользователю из приклепленных групп лидов
            $userLeadGroupsLeads = $this->leadGroups->load('leads')->pluck('leads')->flatten();
            $allLeads = $userLeads->merge($userLeadGroupsLeads);
            //если вызываем из модели пользователя
            if (isset($this->userGroups)) {
                //все лиды, доступные пользователю, которые прикрепленны к группам пользователя
                $userGroupsLeads = $this->userGroups->load('leads')->pluck('leads')->flatten();
                $allLeads = $allLeads->merge($userGroupsLeads);
                //все лиды, доступные пользователю из прикрепленных групп лидов, которые прикрепленны к группам пользователя
                $userGroupsLeadGroupsLeads = $this->userGroups->load('leadGroups.leads')->pluck('leadGroups')->flatten()->pluck('leads')->flatten();
                $allLeads = $allLeads->merge($userGroupsLeadGroupsLeads);
            }
            $allLeads = $allLeads->unique('id')->sortBy('id');
            return collect($allLeads->values()->all());
        //вернуть все новые лиды доступные пользователю
        } else if ($leadGroupCode == 'new') {
            //новые лиды, которые не привязаны к группе лидов, доступные пользователю
            $userLeads = $this->leads->whereNull('lead_group_id')->whereNull('lead_status_id');
            if (isset($this->userGroups)) {
                //новые лиды, которые не привязаны к группе лидов, доступные пользователю из его пользовательских групп
                $userGroupsLeads = $this->userGroups->load('leads')->pluck('leads')->flatten()->whereNull('lead_group_id')->whereNull('lead_status_id');
            }
            $allLeads = $userLeads->merge($userGroupsLeads);
            $allLeads = $allLeads->unique('id')->sortBy('id');
            return collect($allLeads->values()->all());
        //вернуть все лиды доступные пользователю в рамках одной группы лидов
        } else {
            // $leadGroup = LeadGroup::where('code', $leadGroupCode)->firstOrFail();
            //все лиды, прикрепленные к конкретной группе лидов, доступные пользователю
            $userLeadGroupLeads = $this->leadGroups->where('code', $leadGroupCode)->load('leads')->pluck('leads')->flatten();
            // $userLeadGroupsLeads = $this->leadGroups->where('id', $leadGroup->id)->load('leads')->pluck('leads')->flatten();
            if (isset($this->userGroups)) {
                //лиды, прикрепленные к конкретной группе лидов, доступные пользователю из его пользовательских групп
                $userGroupLeadGroupLeads = $this->userGroups->load('leadGroups.leads')->pluck('leadGroups')->flatten()->where('code', $leadGroupCode)->pluck('leads')->flatten();
                // $userGroupsLeads = $this->userGroups->load('leadGroups.leads')->pluck('leadGroups')->flatten()->pluck('leads')->flatten()->where('lead_group_id', $leadGroup->id);
            }
            $allLeads = $userLeadGroupLeads->merge($userGroupLeadGroupLeads);
            $allLeads = $allLeads->unique('id')->sortBy('id');
            return collect($allLeads->values()->all());
        }
    }
}
