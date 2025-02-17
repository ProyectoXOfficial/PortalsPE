<?php
declare(strict_types=1);

namespace luca28pet\PortalsPE\listener;

use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\block\Block;

class BlockPlaceEventListener extends BaseListener{

    public function onBlockPlace(BlockPlaceEvent $event) : void{
        $ses = $this->plugin->getSessionManager()->getSession($event->getPlayer());
        foreach($event->getTransaction()->getBlocks() as [$x, $y, $z, $block]){
            /**  @var Block $block */
            if($ses !== null){
                if($ses->isSelectingFirstBlock()){
                    $event->cancel();
                    $ses->getSelection()->setFirstBlockWithFolderName($block->getPosition()->asVector3(), $event->getPlayer()->getWorld()->getFolderName());
                    $event->getPlayer()->sendMessage('First pos set');
                    $ses->setSelectingFirstBlock(false);
                }elseif($ses->isSelectingSecondBlock()){
                    $event->cancel();
                    $ses->getSelection()->setSecondBlockWithFolderName($block->getPosition()->asVector3(), $event->getPlayer()->getWorld()->getFolderName());
                    $event->getPlayer()->sendMessage('Second pos set');
                    $ses->setSelectingSecondBlock(false);
                }
            }
        }
    }

}