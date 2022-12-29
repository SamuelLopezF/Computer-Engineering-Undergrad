package Master;

import List.DList;
import SimpleTree.SimpleTree;
import SimpleTree.SimpleTreeNode;

import java.util.Arrays;
import java.util.Dictionary;


/** Samuel Lopez-Ferrada
 *
 * This file contains the Doubly Linked List class. It manages two lists in parallel
 * and links them together. It uses the List.LList class and implements the
 * Abstract Data Type Dictionary Interface.
 * @param <Key> corresponds to the given key;
 * @param <E> corresponds to the given element;
 */

public class DLDictionary<Key, E extends Comparable <E> > implements ADTDictionary<Key, E> {

    private static final int defaultSize = 100; //Default size

    private DList<Key> kDList;
    private DList<E> vDList;

    /**
     * Constructors:
     *
     * @param size is the length of the list
     */
    public DLDictionary(int size) {
        kDList = new DList<Key>(size);
        vDList = new DList<E>(size);
    }

    /*
        Start of functions :
     */

    /**
     * This function empties both lists
     */
    public void clear() {
        kDList.clear();
        vDList.clear();
    }

    /**
     * This function appends an item at the end of the list
     * give a Key Value pair. It will first search sequentially
     * if the key is already stored in the list
     *
     * @param k The key for the record being inserted.
     * @param e The record as an object of InventoryRecord being inserted.
     */
    public void insert(Key k, E e) {
        int origin = kDList.currPos();
        for (int i = 0; i <= kDList.length(); i++) {
            if (i == kDList.length()) {
                kDList.moveToEnd();
                vDList.moveToEnd();
                kDList.append(k);
                vDList.append(e);
                break;
            } else if (kDList.getValue().equals(k)) {
                break;
            }
            kDList.next();
            vDList.next();
        }
        kDList.moveToPos(origin);
        vDList.moveToPos(origin);
    }

    /**
     * This function removes a key/value pair
     * given a key, using a sequential search to see
     * if the item exists.
     *
     * @param k The key of the record to be removed.
     * @return the value of the element
     */
    public E remove(Key k) {
        E temp = null;

        int origin = kDList.currPos();
        kDList.moveToStart();
        vDList.moveToStart();
        for (int i = 0; i < kDList.length(); i++) {
            if (kDList.getValue().equals(k)) {
                kDList.remove();
                temp = vDList.remove();
                break;
            }
            kDList.next();
            vDList.next();
        }
        kDList.moveToPos(origin);
        vDList.moveToPos(origin);
        return temp;
    }

    /**
     * This function removes the element the cursor is currently pointing at
     *
     * @return the element that was removed
     */
    public E removeCurrent() {
        kDList.remove();
        return vDList.remove();
    }


    /**
     * Remove any function, removes whatever element the cursor
     * is currently pointing at. The function was vague, so the
     * implementation was not over-complicated
     *
     * @return the element removed, null if cursor pointing at null
     */
    public E removeAny() {
        if (kDList.getCurrent() == null) {
            //this means that current is pointing at the tail
            return null;
        } else {
            return removeCurrent();
        }
    }


    public String getCurrent() {
        return kDList.getValue().toString() + vDList.getValue().toString();
    }

    /**
     * This function searches a key, using sequential search,
     * and return the corresponding element associated.
     *
     * @param k The key of the record to find
     * @return the element corresponding to @param k, null if not found;
     */
    public E find(Key k) {
        int origin = kDList.currPos();
        E temp = null;
        kDList.moveToStart();
        vDList.moveToStart();
        for (int i = 0; i < kDList.length(); i++) {
            if (kDList.getValue().equals(k)) {
                temp = vDList.getValue();
                break;
            }
            kDList.next();
            vDList.next();
        }

        kDList.moveToPos(origin);
        vDList.moveToPos(origin);
        return temp;
    }


    /**
     * Simple method that returns the size, and asserts that both lists
     * have the same length
     *
     * @return the length of the dictionary
     */

    public int size() {
        assert (kDList.length() == vDList.length());
        return kDList.length();
    }

    /**
     * A readable version of the list to be printed on the output console
     *
     * @return a string object
     */
    @Override
    public String toString() {
        int origin = kDList.currPos();
        kDList.moveToStart();
        vDList.moveToStart();
        StringBuffer out = new StringBuffer();
        assert (vDList.length() == kDList.length());
        for (int i = 0; i < kDList.length(); i++) {
            out.append("K : " + kDList.getValue().toString());
            kDList.next();
            out.append(" V : ");
            out.append(vDList.getValue().toString());
            out.append(" | ");
            vDList.next();
        }
        kDList.moveToPos(origin);
        vDList.moveToPos(origin);
        return out.toString().trim();
    }


    //PART 2 :

    public void moveToPos(int i )
    {
        kDList.moveToPos(i);
        vDList.moveToPos(i);
    }

    public void previous() {
        kDList.prev();
        vDList.prev();
    }

    public void next() {
        kDList.next();
        vDList.next();
    }

    public void moveToStart() {
        kDList.moveToStart();
        vDList.moveToStart();
    }

    public E getCurrentValue() {
        return vDList.getValue();
    }

    public int getCurrentPosition() {
        return vDList.currPos();
    }

    public Key getKey() {
        return kDList.getValue();
    }


    // PART TWO //

    /* CreatedIndex takes in a String.
    This string acts like a simple mux between quantity and unit price. This was meant
    to keep the code simple but also meet the requirement to test 2 attributes. More attributes would
    be more code that is very similar.

    The KVPair node is composed of <Integer, E> where integer is the position in the original index,
    E is the attributed tested. THe code is flexible enough in the sense that E extends comparable,
    so any Comparable element can be used with this method.

    Attributes and positions are copied from the inventory, and then they are sorted using merge sort.
     */

    public KVpair[] createIndex(String attribute)
    {

        kDList.moveToStart();
        vDList.moveToStart();
        int[] positions = new int[size()];

        KVpair[] my_sorted_list = new KVpair[size()];
        KVpair[] templ = new KVpair[size()];
        if(attribute.equalsIgnoreCase("quantity"))
        {
            for (int i = 0; i < size(); i++) {
                int temp = ((Inventory) vDList.getValue()).getQuantity();
                my_sorted_list[i] = new KVpair(i, temp);
                vDList.next();
            }

            mergesort(my_sorted_list, templ, 0 , size()-1);
        }else if(attribute.equalsIgnoreCase("unitprice"))
        {
            for (int i = 0; i < size(); i++) {
                float temp = ((Inventory) vDList.getValue()).getUnit_price();
                my_sorted_list[i] = new KVpair(i, temp);
                vDList.next();
            }
            mergesort(my_sorted_list, templ, 0, size()-1);
        }
        vDList.moveToStart();
        return my_sorted_list;
    }


    /*
    This merge sort is sorting trough an array of KVPairs. KVpairs extends comparable
    to another KVPair (See KVpair class for details). In the compareTo method, the KVPair
    node is compare to another through the Value which is an attribute selected in createIndex.

    In the first part of merge sort the function is called recursively on itself to
    split the array in halves and then the recursive call stack is run through a merging phase.
    This results in n log n time.
     */
    public static void mergesort(KVpair[] A, KVpair[] temp, int l, int r)
    {

        int mid = (l+r)/2; // Select midpoint

        if (l == r) {

            return; // List has one element
        }
        mergesort(A, temp, l, mid); // Mergesort first half

        mergesort(A, temp, mid+1, r); // Mergesort second half


        for (int i=l; i<=r; i++)
            temp[i] = A[i];

        // Do the merge operation back to A
        int i1 = l; int i2 = mid + 1;
        for (int curr=l; curr<=r; curr++) {

            if ((i1< mid+1) && (i2<=r)) {
                if (temp[i1].compareTo(temp[i2])<0) // Get smaller
                    A[curr] = temp[i1++];
                else
                    A[curr] = temp[i2++];

            }
            else if ((i1==mid+1) && (i2 <= r) ){ // Left sublit exhausted
                A[curr] = temp[i2++];
            }
            else if (i2 > r) { // Right sublist exhausted
                A[curr] = temp[i1++];
            }
        }
    }



    /*
    In this BSTree, the first node is used as the root. If the root is a min or max,
    the tree behaves like a linked list. Else on average the tree will run log n.

    See Simple tree class for implementation. The base is to compare two SimpleTreeNode
    which is also a KVpair. Only the values are compare. If the value added is less than the
    current node, it goes to left child, else it goes to right child.
     */
    public  SimpleTreeNode createIndexBTS(String attribute)
    {
        vDList.moveToStart();
        SimpleTree my_tree;
        if(attribute.equalsIgnoreCase("UnitPrice"))
        {
            my_tree = new SimpleTree<Integer, Float>();
            for (int i = 0; i < size(); i++) {
                float price = ((Inventory) (vDList.getValue())).getUnit_price();
                my_tree.addFromRoot(i , price);
                vDList.next();
            }
        }else if(attribute.equalsIgnoreCase("Quantity")){
            my_tree = new SimpleTree<Integer, Integer>();
            for (int i = 0; i < size(); i++) {
                int quantity = ((Inventory) (vDList.getValue())).getQuantity();
                my_tree.addFromRoot(i , quantity);
                vDList.next();
            }
        }else{
            my_tree = null;
        }
        //print keys from here
        vDList.moveToStart();
        assert my_tree != null;
        return my_tree.getRoot();
    }

    public void inOrderTraversing(SimpleTreeNode root)
    {
        System.out.println();
        root.traverseInOrder(root);
        System.out.println();
        root.traverseInOrderValues(root);
        System.out.println();
    }


}