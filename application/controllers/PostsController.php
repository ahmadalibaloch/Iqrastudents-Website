<?php
class PostsController extends Controller
{
	function defaultAction()
	{
		User::checkPermission('Can Post');
		
		$logdUser = User::getLoggedIn();
		
		$posts = Post::getAll("usrId = {$logdUser->getId()} order by id desc");
		
		$this->set('name', 'My ');
		$this->set('posts', $posts);
		$this->set('logdUser', $logdUser);
		
		return $this->view();
	}
	
	function recentAction()
	{
		User::checkPermission('Can Post');
		
		$logdUser = User::getLoggedIn();
		
		$append = "usrId in({$logdUser->getId()},";
		
		if($friends = Friendship::getFriends($logdUser))
		{
			foreach($friends as $f)	$append .= $f->getId().',';		
		}
		
		$append = substr($append, 0, -1).")";
		
		$posts = Post::getAll("$append order by id desc");
		
		$this->set('name', 'Recent ');
		$this->set('logdUser', $logdUser);
		$this->set('posts', $posts);
		
		return $this->view('Posts.default');
	}
	
	function addAction()
	{
		User::checkPermission('Can Post');		
		$logdUser = User::getLoggedIn();
		
		$form = new Form('post');
		$content = $form->add('content', 'bigtext|text|,20000', true);
		
		$r['post'] = null;
		$r['postId'] = 0;
		
		
		if($form->validate())
		{
			$post = new Post();
			$post->setUsrId($logdUser->getId());
			$post->setContent($content->getValue());
			$post->setCategory('text');
			$post->setAdded(date('Y-m-d h:i:s'));
			$post->save();
			$content->setValue('');
			
			$this->set('post', $post);
			$this->set('logdUser', $logdUser);
			
			$r['post'] = $this->view('Posts.post');
			$r['postId'] = $post->getId();
		}
		
		$this->set('form', $form);		
		$r['form'] = $this->view('Posts.form');

		return json_encode($r);
	}
	
	function removeAction($id = 0)
	{
		User::checkPermission('Can Post');		
		$logdUser = User::getLoggedIn();

		$id = intval($id);
		
		$r['status'] = 'failure';
		$r['postId'] = $id;
		
		if(Post::delete("usrId = {$logdUser->getId()} and id = $id"))
		{
			$r['status'] = 'success';
		}
		
		return json_encode($r);
	}
}
