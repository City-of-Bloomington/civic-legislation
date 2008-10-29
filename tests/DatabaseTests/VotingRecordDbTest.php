<?php
require_once 'PHPUnit/Framework.php';

/**
 * Test class for VotingRecord.
 * Generated by PHPUnit on 2008-09-29 at 10:55:57.
 */
class VotingRecordDbTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var    VotingRecord
     * @access protected
     */

	protected $committee;
	protected $topic;
	protected $voteType;
	protected $member;
	protected $seat;	
	protected $vote;
	protected $appointer;
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
	protected function setUp()
	{
		$dir = dirname(__FILE__);
		exec('/usr/local/mysql/bin/mysql -u '.DB_USER.' -p'.DB_PASS.' '.DB_NAME." < $dir/../testData.sql");

		$topicType = new TopicType();
		$topicType->setName('Vote Test TopicType');
		$topicType->save();

		$committee = new Committee();
		$committee->setName('Vote Test Committee');
		$committee->save();
		$this->committee = $committee;

		$topic = new Topic();
		$topic->setCommittee($this->committee);
		$topic->setTopicType($topicType);
		$topic->setNumber(111);
		$topic->setDescription('Test Topic Description');
		$topic->setSynopsis('Test Topic Synopsis');
		$topic->save();
		$this->topic = $topic;

		$voteType = new VoteType();
		$voteType->setName('Test Vote Type');
		$voteType->save();
		$this->voteType = $voteType;

		$vote = new Vote();
		$vote->setVoteType($this->voteType);
		$vote->setTopic($this->topic);
		$vote->setDate(strtotime('yesterday'));
		$vote->save();

		$user = new User();
		$user->setFirstname("ftest");
		$user->setLastname("ltest");
		$user->save();
		$this->user = $user;

		$seat = new Seat();
		$seat->setTitle("Seat Test");
		$seat->setCommittee_id($committee->getId());
		$seat->setAppointer_id($appointer->getId());
		$seat->save();
		$this->seat = $seat;

		$member = new Member();
		$member->setUser_id($user->getId());
		$member->setSeat_id($seat->getId());
		$member->setTerm_start(strtotime('yesterday'));
		$member->setTerm_end(strtotime('+2 y'));
		$member->save();
		$this->member = $member;

	}


    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown()
    {
    }

    public function testSaveLoad()
    {
		$votingRecord = new VotingRecord();
		$votingRecord->setVote($this->vote);
		$votingRecord->setMember($this->member);
		$votingRecord->setMemberVote("yes");
    	try
		{
			$votingRecord->save();
			$id = $votingRecord->getId();
			$this->assertGreaterThan(0,$id);
		}
		catch (Exception $e) { $this->fail($e->getMessage()); }

		$votingRecord = new VotingRecord($id);
		$this->assertEquals($votingRecord->getDate('Y-m-d'),date('Y-m-d',strtotime('yesterday')));

    }

    public function testGetVote()
    {
		$votingRecord = new VotingRecord();
		$votingRecord->setVote_id($this->vote->getId());
		$this->assertEquals($votingRecord->getVote()->getId(),$this->vote->getId());
    }

    public function testGetMember()
    {
		$votingRecord = new VotingRecord();
		$votingRecord->setMember_id($this->member->getId());
		$this->assertEquals($votingRecord->getMember()->getId(),$this->Member->getId());
    }

    public function testGetMemberVote()
    {
		$votingRecord = new VotingRecord();
		$votingRecord->setMemberVote('yes');
		$this->assertEquals($votingRecord->getMemberVote(),'yes');
    }

    /**
     * @todo Implement testValidate().
     */
    public function testValidate() {
	$votingRecord = new VotingRecord();

    }

}
?>
