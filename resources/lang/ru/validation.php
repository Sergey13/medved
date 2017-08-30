<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "Поле :attribute должно быть одобренно.",
	"active_url"           => "Поле :attribute содержит не действительный URL.",
	"after"                => "Поле :attribute должно быть после даты :date.",
	"alpha"                => "Поле :attribute может содержать только буквы.",
	"alpha_dash"           => "Поле :attribute может содержать только буквы, цифры, и знак тире.",
	"alpha_num"            => "Поле :attribute может содержать только буквы и цифры.",
	"array"                => "Поле :attribute должно быть массивом.",
	"before"               => "Поле :attribute должно содержать дату перед :date.",
	"between"              => [
		"numeric" => "Поле :attribute должно содержать значение между :min и :max.",
		"file"    => "Поле :attribute должно быть не меньше :min и не больше :max КБ.",
		"string"  => "Поле :attribute должно содержать не меньше :min и не больше :max знаков.",
		"array"   => "Поле :attribute должно содержать не меньше :min и не больше :max значений.",
	],
	"boolean"              => "Поле :attribute должно быть истинным или ложным.",
	"confirmed"            => "Поле :attribute - не совпадают подтверждения.",
	"date"                 => "В поле :attribute введена некорректная дата.",
	"date_format"          => "Поле :attribute не соответствует формату :format.",
	"different"            => "Поле :attribute и :other должны быть разными.",
	"digits"               => "Поле :attribute должно отличаться от значения поля :digits.",
	"digits_between"       => "Значение :attribute должно быть между :min и :max цифрами.",
	"email"                => "Поле :attribute содержит некорректный е-mail адрес.",
	"filled"               => "Поле :attribute обязательно необходимо заполнить.",
	"exists"               => "Выбранное значение :attribute некорректное.",
	"image"                => "Поле :attribute должно содержать картинку.",
	"in"                   => "Выбранное значение :attribute некорректное.",
	"integer"              => "Значение :attribute должно быть целым.",
	"ip"                   => "Поле :attribute должно содержать действительный IP адрес.",
	"max"                  => [
		"numeric" => "Значение :attribute не должно быть больше :max.",
		"file"    => "Файл :attribute не должен привышать :max КБ.",
		"string"  => "Поле :attribute не должно содержать больше :max символов.",
		"array"   => "Поле :attribute не должно содержать больше :max значений.",
	],
	"mimes"                => "Поле :attribute должно содержать файл типа: :values.",
	"min"                  => [
		"numeric" => "Значение :attribute не должно быть меньше :min.",
		"file"    => "Файл :attribute не должен быть меньше :min КБ.",
		"string"  => "Поле :attribute должно содержать не меньше :min символов.",
		"array"   => "Поле :attribute должно содержать не меньше :min значений.",
	],
	"not_in"               => "Выбранное значение :attribute является недействительным.",
	"numeric"              => "Поле :attribute должно содержать число.",
	"regex"                => "Поле :attribute содержит недействительный формат.",
	"required"             => "Поле :attribute необходимо обязательно заполнить.",
	"required_if"          => "Поле :attribute необходимо обязательно заполнить, если значение :other содержит :value.",
	"required_with"        => "Поле :attribute необходимо обязательно заполнить, если присутствует :values .",
	"required_with_all"    => "Поле :attribute необходимо обязательно заполнить, если присутствует :values .",
	"required_without"     => "Поле :attribute необходимо обязательно заполнить, если отсутствует :values .",
	"required_without_all" => "Необходимо заполнить или :attribute, или :values .",
	"same"                 => "Поле :attribute и :other должны совпадать.",
	"size"                 => [
		"numeric" => "Значение :attribute должно быть :size.",
		"file"    => "Файл :attribute должен быть :size КБ.",
		"string"  => "Поле :attribute должно содержать :size символов.",
		"array"   => "Поле :attribute должно содержать :size значений.",
	],
	"unique"               => "Данное значение :attribute уже существует.",
	"url"                  => "Формат поля :attribute является недействительным.",
	"timezone"             => "Значение поля :attribute должно соответсвовать временной зоне.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
                'password' => [
                    'required' => 'Поле пароль необходимо обязательно заполнить.'
                ],
                'fio' => [
                    'required' => "ФИО необходимо обязательно указать.",
                ],
                'name' => [
                    'required' => 'Название необходимо обязательно указать.',
                    'unique' => "Данное название уже существует. Введите новое."
                ],
                'email' => [
                  'required' => '"E-mail адрес" необходимо обязательно заполнить'  
                ],
                'phone' => [
                    'required' => 'Поле телефон необходимо обязательно заполнить'
                ],
                'place' => [
                    'required_without' => 'Выберите место установки оборудования'
                ],
                'place_add' => [
                    'required_without' => 'Введите новое место установки оборудования или выберите из списка уже сущесвтующих'
                ],
                'installation_date' => [
                    'required' => 'Укажите, пожалуйста, дату установки оборудования',
                    'date' => 'Формат даты должен быть "Год-месяц-день"'
                ],
                'date_of_employment' => [
                    'required' => 'Укажите, пожалуйста, дату оформления',
                    'date' => 'Формат даты должен быть "Год-месяц-день"'
                ],
                'pasport' => [
                    'required_without_all' => 'Укажите данные паспорта или загрузите скан-копию документа'
                ],
                'document' => [
                    'required_without_all' => 'Загрузите скан-копию паспорта или введите данные в поле "Паспорт изделия"',
                    'image' => 'Файл должен быть изображением в формате .png, .jpeg, .jpg'
                ],
                'inventory_number' => [
                    'required' => 'Укажите, пожалуйста, инвентаризационный номер оборудования',
                    'numeric' => 'Поле "Инвентаризационный номер" должен содержать число'
                ],
                'equipment' => [
                    'required' => 'Выберите, пожалуйста, оборудование для комплектующего'
                ],
                'number' => [
                    'required_without' => 'Поле необходимо обязательно заполнить'
                ],
                'count' => [
                    'required' => 'Необходимо обязательно указать количество',
                    'numeric' => 'Значение должно быть числовым',
                    'integer' => ' Число должно быть целым',
                    'min' => 'Значение не может быть меньше :min',
                    'max' => 'Значение не может быть больше :max'
                ],
                'count_in' => [
                    'required' => 'Необходимо обязательно указать количество',
                    'numeric' => 'Значение должно быть числовым',
                    'integer' => ' Число должно быть целым',
                    'min' => 'Значение не может быть меньше :min',
                    'max' => 'Значение не может быть больше :max'
                ],
                'component_id' => [
                    'required' => 'Необходимо указать комплектующее'
                ],
                'equipment_id' => [
                    'required' => 'Необходимо указать оборудование'
                ],
                'tool_name' => [
                    'unique' => 'Инструмент с таким названием уже существует. Выберите из списка.',
                    'required_without' => 'Введите новое название инструмента или выберите из списка уже сущесвтующий'
                ],
				'material_name' => [
					'unique' => 'Материал с таким названием уже существует. Выберите из списка.',
					'required_without' => 'Введите новое название материала или выберите из списка уже сущесвтующий'
				],
                'tool_id' => [
                    'required_without' => 'Необходимо выбрать инструмент или введите новое название'
                ],
                'material_id' => [
                    'required_without' => 'Необходимо выбрать материал или введите новое название'
                ],
                'type' => [
                    'required' => 'Укажите расход это или приход',
                    'regex' => 'Указано неверный формат значения'
                ],
                'date' => [
                    'required' => 'Укажите, пожалуйста, дату',
                    'date' => 'Формат даты должен быть "Год-месяц-день"',
                    'date_format' => 'Указан неверный формат',
                ],
                'performer_id' => [
                    'required_if' => 'Укажите кому выдано комплектующее'
                ],
                'balance_notification' => [
                    'required_if' => 'Укажите остаток, при котором придет уведомление о необходимом пополнении',
					'required' => 'Укажите остаток, при котором придет уведомление о необходимом пополнении',
                ],
                'year' => [
                    'required' => 'Необходимо обязательно указать год',
                    'date_format' => 'Указан неверный формат',
                ],
                'day.*' => [
                    'required_with' => 'Укажите пожалуйста день месяца',
                    'date_format' => 'Указан неверный форма'
                ],
                'performer' => [
                    'required' => 'Необходимо обязательно указать исполнителя',
                ],
                'type_of_repair' => [
                    'required' => 'Необходимо обязательно указать тип ремонта',
                ],
                'schedule_id' => [
                    'required_if' => 'Необходимо выбрать из списка дату ремонта, если он плановый'
                ]
            
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [],

];
