<?php


class Bitrix
{
    public static function addDeal($username, $phone) 
    {
        $id = Bitrix::addContact($username, $phone);
        
        CRest::call(
            'crm.deal.add',
            [
                'fields' =>[
                    'TITLE' => ($username ?? 'Заявка') . ' ' . $phone,
                    'CONTACT_ID' =>  $id
                ]
            ]);
    }
    
    public static function addContact($username, $phone)
    {
        $data = CRest::call(
            'crm.contact.add',
            [
                'fields' =>[
                    'NAME' => $username,
                    "TYPE_ID" => "CLIENT",
                    'PHONE' => [[
                        'VALUE' => $phone,
                        'VALUE_TYPE' => "MOBILE"
                        ]],  
                    ]
            ]);
            
        return $data['result'];
    }
}