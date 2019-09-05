<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\AnswerDetail
 *
 * @property int $id
 * @property int $answer_id
 * @property int $type
 * @property string $button_mm3
 * @property string $message_mm3
 * @property string $button_zg
 * @property string $message_zg
 * @property string $button_en
 * @property string $message_en
 * @property string $image
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail whereAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail whereButtonEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail whereButtonMm3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail whereButtonZg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail whereMessageEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail whereMessageMm3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail whereMessageZg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnswerDetail whereUpdatedAt($value)
 */
	class AnswerDetail extends \Eloquent {}
}

namespace App{
/**
 * App\Conversation
 *
 * @property int $id
 * @property int $fb_user_id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Reply[] $replies
 * @property-read int|null $replies_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conversation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conversation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conversation whereFbUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conversation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conversation whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conversation whereUpdatedAt($value)
 */
	class Conversation extends \Eloquent {}
}

namespace App{
/**
 * App\FbUser
 *
 * @property int $id
 * @property string $psid
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $firstName
 * @property string|null $lastName
 * @property string|null $profilePic
 * @property string|null $locale
 * @property string|null $timezone
 * @property string|null $gender
 * @property int $conversation
 * @property int $seen
 * @property \Illuminate\Support\Carbon $active_at
 * @property int $timeout
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Conversation[] $conversations
 * @property-read int|null $conversations_count
 * @property-read mixed $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser notSeen()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser seen()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser whereActiveAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser whereConversation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser whereProfilePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser wherePsid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser whereSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser whereTimeout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FbUser whereUpdatedAt($value)
 */
	class FbUser extends \Eloquent {}
}

namespace App\Models\Answers{
/**
 * App\Models\Answers\Answer
 *
 * @property int $id
 * @property int $question_id
 * @property string|null $traceAId
 * @property string|null $button_mm3
 * @property string|null $message_mm3
 * @property string|null $button_zg
 * @property string|null $message_zg
 * @property string|null $button_en
 * @property string|null $message_en
 * @property string|null $image
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $large_image
 * @property-read string $thumbnail
 * @property-read \App\Models\Questions\Question $question
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer getAnswers($questionId)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel searchMessage($keyword, $column)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer whereButtonEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer whereButtonMm3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer whereButtonZg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer whereMessageEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer whereMessageMm3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer whereMessageZg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer whereTraceAId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Answers\Answer whereUpdatedAt($value)
 */
	class Answer extends \Eloquent {}
}

namespace App\Models\AnswerTypes{
/**
 * App\Models\AnswerTypes\AnswerType
 *
 * @property int $id
 * @property int $answer_id
 * @property int $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerTypes\AnswerType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerTypes\AnswerType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerTypes\AnswerType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerTypes\AnswerType whereAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerTypes\AnswerType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerTypes\AnswerType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerTypes\AnswerType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AnswerTypes\AnswerType whereUpdatedAt($value)
 */
	class AnswerType extends \Eloquent {}
}

namespace App\Models\Questions{
/**
 * Class Question
 *
 * @package App\Models\Questions
 * @property int $id
 * @property int $parent_id
 * @property string|null $traceQId
 * @property string|null $tracePId
 * @property string|null $button_mm3
 * @property string|null $message_mm3
 * @property string|null $button_zg
 * @property string|null $message_zg
 * @property string|null $button_en
 * @property string|null $message_en
 * @property string|null $image
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $large_image
 * @property-read string $thumbnail
 * @property-read \App\Models\Questions\Question $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question getSubQuestions($parentId)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel searchMessage($keyword, $column)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question subQuestions($parentId)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question top()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question whereButtonEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question whereButtonMm3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question whereButtonZg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question whereMessageEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question whereMessageMm3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question whereMessageZg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question whereTracePId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question whereTraceQId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questions\Question whereUpdatedAt($value)
 */
	class Question extends \Eloquent {}
}

namespace App\Models\QuestionTypes{
/**
 * App\Models\QuestionTypes\QuestionType
 *
 * @property int $id
 * @property int $question_id
 * @property int $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionTypes\QuestionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionTypes\QuestionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionTypes\QuestionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionTypes\QuestionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionTypes\QuestionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionTypes\QuestionType whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionTypes\QuestionType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionTypes\QuestionType whereUpdatedAt($value)
 */
	class QuestionType extends \Eloquent {}
}

namespace App{
/**
 * App\Reply
 *
 * @property int $id
 * @property int $user_id
 * @property int $conversation_id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereConversationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereUserId($value)
 */
	class Reply extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $role
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Reply[] $replies
 * @property-read int|null $replies_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

